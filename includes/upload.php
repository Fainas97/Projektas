<?php

class  Media
{

    public $imageInfo;
    public $fileName;
    public $fileType;
    public $fileTempPath;
    //Set destination for upload
    public $userPath = SITE_ROOT . DS . '..' . DS . 'uploads/users';


    public $errors = array();
    public $upload_errors = array(
        0 => 'Klaidos nėra, failas įkeltas sėkmingai',
        1 => 'Įkeltas failas viršija upload_max_filesize direktyvą php.ini',
        2 => 'Įkeltas failas viršija MAX_FILE_SIZE direktyvą, nurodytą HTML formoje',
        3 => 'Įkeltas failas buvo tik iš dalies įkeltas',
        4 => 'Failas nebuvo įkeltas',
        6 => 'Trūksta laikino aplanko',
        7 => 'Nepavyko įrašyti failo į diską.',
        8 => 'PHP plėtinys sustabdė failo įkėlimą.'
    );
    public $upload_extensions = array(
        'gif',
        'jpg',
        'jpeg',
        'png',
    );

    public function upload($file)
    {
        if (!$file || empty($file) || !is_array($file)):
            $this->errors[] = "Failas nebuvo įkeltas.";
            return false;
        elseif ($file['error'] != 0):
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        elseif (!$this->file_ext($file['name'])):
            $this->errors[] = 'Failo neteisingas formatas';
            return false;
        else:
            $this->imageInfo = getimagesize($file['tmp_name']);
            $this->fileName = basename($file['name']);
            $this->fileType = $this->imageInfo['mime'];
            $this->fileTempPath = $file['tmp_name'];
            return true;
        endif;

    }

    public function file_ext($filename)
    {
        $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
        if (in_array($ext, $this->upload_extensions)) {
            return true;
        }
    }
    /*--------------------------------------------------------------*/
    /* Function for Process user image
    /*--------------------------------------------------------------*/

    public function process_user($id)
    {

        if (!empty($this->errors)) {
            return false;
        }
        if (empty($this->fileName) || empty($this->fileTempPath)) {
            $this->errors[] = "Failo vieta nepasiekiama";
            return false;
        }
        if (!is_writable($this->userPath)) {
            $this->errors[] = $this->userPath . "Turi būti įrašomi!!!";
            return false;
        }
        if (!$id) {
            $this->errors[] = "Trūksta vartotojo ID";
            return false;
        }
        $ext = explode(".", $this->fileName);
        $new_name = randString(8) . $id . '.' . end($ext);
        $this->fileName = $new_name;
        if ($this->user_image_destroy($id)) {
            if (move_uploaded_file($this->fileTempPath, $this->userPath . '/' . $this->fileName)) {

                if ($this->update_userImg($id)) {
                    unset($this->fileTempPath);
                    return true;
                }

            } else {
                $this->errors[] = "Failo įkėlimas nepavyko, galbūt dėl neteisingų įkėlimo aplanko teisių.";
                return false;
            }
        }
    }
    /*--------------------------------------------------------------*/
    /* Function for Update user image
    /*--------------------------------------------------------------*/

    public function user_image_destroy($id)
    {
        $image = find_by_id('users', $id);
        if ($image['image'] === 'no_image.jpg') {
            return true;
        } else {
            unlink($this->userPath . '/' . $image['image']);
            return true;
        }

    }
    /*--------------------------------------------------------------*/
    /* Function for Delete old image
    /*--------------------------------------------------------------*/

    private function update_userImg($id)
    {
        global $db;
        $sql = "UPDATE users SET";
        $sql .= " image='{$db->escape($this->fileName)}'";
        $sql .= " WHERE id='{$db->escape($id)}'";
        $result = $db->query($sql);
        return ($result && $db->affected_rows() === 1 ? true : false);

    }
}


?>
