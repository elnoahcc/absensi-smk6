<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AttendanceModel;
use App\Models\UserModel;
use App\Models\ScheduleModel;
use CodeIgniter\HTTP\ResponseInterface;

class Log extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->attendanceModel = new AttendanceModel();
        $this->scheduleModel = new ScheduleModel();
    }

    public function index()
    {
        $data['title'] = "Log";
        $data['subtitle'] = "Log";
        $id = session('user_id');

        $data['user'] = $this->userModel
            ->select('users.*, categories.name as category_name')
            ->join('categories','categories.id = users.category_id','left')
            ->find($id);

    $data['attendancecount'] = $this->attendanceModel
        ->select("user_id,
            COUNT(CASE WHEN status = 'Hadir' THEN 1 END) AS count_hadir, 
            COUNT(CASE WHEN status = 'Ijin' THEN 1 END) AS count_ijin, 
            COALESCE(MAX(CASE WHEN DATE(created_at) = CURDATE() THEN status END),'Tidak Hadir') AS status_today")
        ->where('user_id', $id)
        ->groupBy('user_id')
        ->orderBy('user_id')
        ->first();

        return view('pages/log/list',$data);
    }

    public function getData()
    {
        $id = session('user_id');

        $currentDate = date('Y-m-d');
        $currentDay = date('l');
        $currentTime = strtotime(date('H:i:s'));

        $user = $this->userModel
            ->select('id, name, category_id')
            ->where('id', $id)
            ->first();

        $categoryId = $user['category_id'];

        $existingAttendance = $this->attendanceModel
            ->select('id, activity, description, status, user_id, image')
            ->where('user_id', $id)
            ->like('created_at', $currentDate, 'after')
            ->first();

        // Masuk online dinonaktifkan untuk versi sekolah.
        if (!$existingAttendance) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Fitur masuk online dinonaktifkan.',
            ])->setStatusCode(200);
        }

        $output = $existingAttendance;
        $output['status'] = 'success';
        $output['message'] = '';
        return $this->response->setJSON($output);
    }

    public function getDataId($id)
    {
        $currentDate = date('Y-m-d');

        $existing = $this->attendanceModel
            ->select('id, activity, description, created_at, image, status, user_id')
            ->where('id', $id)
            ->first();

        $output = [
            'id' => $existing['id'],
            'user_id' => $existing['user_id'],
            'status_id' => $existing['status'],
            'activity' => $existing['activity'],
            'description' => $existing['description'],
            'image' => $existing['image'],
            'date' => date('Y-m-d',strtotime($existing['created_at'])),
            'status' => 'success',
        ];
        return $this->response->setJSON($output);
    }

    public function store()
    {
        $id = session('user_id');
        $currentDate = date('Y-m-d');

        $todayAttendance = $this->attendanceModel
            ->select('id, activity, description, image')
            ->where('user_id', $id)
            ->like('created_at', $currentDate, 'after')
            ->first();

        $data = [
            'activity' => $this->request->getPost('activity'),
            'description' => $this->request->getPost('description'),
        ];

        if($todayAttendance) {
            if ($this->request->getFile('image') && $this->request->getFile('image')->isValid()) {
                $oldimage = $todayAttendance['image'];
                $image = $this->request->getFile('image');
                $originalName = $image->getRandomName();
                $tempPath = 'images/data/temp/' . $originalName;
                $jpgName = pathinfo($originalName, PATHINFO_FILENAME) . '.jpg';
                $jpgPath = 'images/data/'.$id.'/' . $jpgName;
                $data['image'] = $jpgName;
                $imagePath = 'images/data/temp/';
                $image->move($imagePath, $originalName);
                $this->convertAnyToJpg($tempPath, $jpgPath);
                unlink($tempPath);
                if ($this->attendanceModel->update($todayAttendance['id'], $data)) {
                    $path = "images/data/".$id.'/';
                    if (file_exists($path.$oldimage)) {
                        unlink($path.$oldimage);
                    }
                    return redirect()->to('log')->with('success', 'Log berhasil disimpan.');
                } else {
                    return redirect()->back()->with('error', 'Log gagal disimpan. db gagal');
                }
            } else {
                if ($this->attendanceModel->update($todayAttendance['id'], $data)) {
                    return redirect()->to('log')->with('success', 'Log berhasil disimpan.');
                } else {
                    return redirect()->back()->with('error', 'Log gagal disimpan. db gagal');
                }
            }
        } else {
            // Menonaktifkan pembuatan absen online baru di versi sekolah
            return redirect()->back()->with('error', 'Fitur masuk online dinonaktifkan.');
        }

    }
    private function convertAnyToJpg($sourcePath, $targetPath, $quality = 50)
    {
        $info = getimagesize($sourcePath);
        if (!$info) return false;

        $mime = $info['mime'];
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($sourcePath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($sourcePath);
                break;
            default:
                return false; // Format tidak didukung
        }

        // Buat canvas baru & hilangkan transparansi (isi putih)
        $width = imagesx($image);
        $height = imagesy($image);
        $bg = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($bg, 255, 255, 255);
        imagefill($bg, 0, 0, $white);
        imagecopy($bg, $image, 0, 0, 0, 0, $width, $height);

        // Simpan jadi JPG
        imagejpeg($bg, $targetPath, $quality);

        imagedestroy($image);
        imagedestroy($bg);

        return true;
    }
}
