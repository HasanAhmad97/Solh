<?php

namespace App\lib;

class FilesUpload
{
    public $_allowext;
    public $_nameprefix;
    protected $_error;
    protected $_disallow_mime;
    public $_fileinfo;
    public $_uploadfolder;
    private $tmpName;
    public $_urlinfo;
    public $_upload_filetype;
    public $_uploadurl;
    public $_logoimages;

    public function __construct($FolderPath = 'Files', $FilePreffix = 'File-', $uploadurl =
    'download', $allowext = '', $_upload_filetype = 'general')
    {
        if ($allowext == '')
            $this->_allowext = $GLOBALS['Config']['Files']['CanUpload_ext'];
        else
            $this->_allowext = $allowext;
        $this->_nameprefix = $FilePreffix;
        $this->_upload_filetype = $_upload_filetype;
        $this->_uploadurl = $uploadurl;
        $this->_error = array();
        $this->_fileinfo = array();
        $this->_logoimages = false;
        $this->_disallow_mime = array(
            "text/html",
            "text/plain",
            "magnus-internal/shellcgi",
            "application/x-php",
            "text/php",
            "application/x-httpd-php",
            "application/php",
            "magnus-internal/shellcgi",
            "text/x-perl",
            "application/x-perl",
            "application/x-exe",
            "application/exe",
            "application/x-java",
            "application/java-byte-code",
            "application/x-java-class",
            "application/x-java-vm",
            "application/x-java-bean",
            "application/x-jinit-bean",
            "application/x-jinit-applet",
            "magnus-internal/shellcgi",
            "image/svg",
            "image/svg-xml",
            "image/svg+xml",
            "text/xml-svg",
            "image/vnd.adobe.svg+xml",
            "image/svg-xml",
            "text/xml"); // أنواع الملفات الممنوعة من التحميل من الجهاز
        $this->_uploadfolder = $FolderPath;
    }

    function img_string_upload($img_content, $img_path)
    {
        //$newName = date("YmdHisu", time());
        if (!is_dir($this->_uploadfolder . "/")) {
            $this->return_error('مجلد رفع الملفات "' . $this->_uploadfolder .
                "/" . '" غير موجود');
            return false;
        }
        if ($img_content == "") {
            $this->return_error('فضلاً تحقق من إختيارك للصورة المراد رفعها');
            return false;
        }
        $this->tmpName = explode("/", $img_path);
        $this->tmpName = $this->tmpName[count($this->tmpName) - 1];
        $upfile[name] = $this->tmpName;
        $upfile[ext] = $this->GetExt($this->tmpName);
        $upfile[place] = $this->_uploadfolder . "/";
        $upfile[newname] = $this->_nameprefix . $this->uniqname() . "." . $upfile[ext];
        $upfile[thplace] = $this->_uploadfolder . "/thumbs/";
        if (!$this->CheckExt($upfile[ext])) {
            $this->return_error('صيغة الملف المراد رفعه ممنوعة');
            return false;
        }
        $file = base64_decode($img_content);
        if (!$file) {
            $this->return_error('لم يتمكن من تحميل الملف : ' . $img_path);
            return false;
        }
        $path = $this->_uploadfolder . "/" . $upfile[newname];
        $fp = @fopen($path, 'w+');
        if (!$fp) {
            $this->return_error('تم حصول خطأ غير متوقع أثناء محاولة رفع الصورة للسيرفر');
            return false;
        }
        $Write = @fwrite($fp, $file);
        if (!$Write) {
            $this->return_error('تم حصول خطأ أثناء محاولة حفظ الصورة');
            return false;
        }
        fclose($fp);
        $upfile['fileurl'] = $GLOBALS['Config']['Tools']['script_path'] . $this->
            _uploadurl . '/' . $upfile[newname];
        $path = $upfile["place"] . $upfile["newname"];
        $upfile['size'] = filesize($path);
        //50x50
        $thumbs = $this->createthumb($path, $upfile[ext], $upfile[thplace] .
            '50x50_' . $upfile[newname], 50, 50);
        //100x100
        $thumbs = $this->createthumb($path, $upfile[ext], $upfile[thplace] .
            '100x100_' . $upfile[newname], 100, 100);
        //300x200
        $thumbs = $this->createthumb($path, $upfile[ext], $upfile[thplace] .
            '300x200_' . $upfile[newname], 300, 200);
        if (!$thumbs) {
            // Delete the original file and the thumbs file
            @unlink($upfile[place] . $upfile[newname]);
            @unlink($upfile[thplace]);
            // return error
            return false;
        }
        $this->ReduceRes($this->_fileinfo[place] . $this->_fileinfo[newname], $this->
        _fileinfo[ext]);
        return $upfile;
    }

    function UrlUpload($url)
    {
        if (!is_dir($this->_uploadfolder . "/")) {
            $this->return_error('مجلد رفع الملفات "' . $this->_uploadfolder .
                "/" . '" غير موجود');
            return false;
        } else { //بداية التحقق من المجلد هل هو موجود ام لا
            $parse = parse_url($url);
            $oldUrl = $url;
            $url = str_replace('?' . $parse['query'], '', $url);
            $this->tmpName = explode("/", $url);
            $this->tmpName = $this->tmpName[count($this->tmpName) - 1];
            $upfile[name] = $this->tmpName;
            $upfile[ext] = $this->GetExt($this->tmpName);
            $upfile[place] = $this->_uploadfolder . "/";
            $upfile[newname] = $this->_nameprefix . $this->uniqname() . "." . $upfile[ext];
            $upfile[thplace] = $this->_uploadfolder . "/thumbs/";
        }
        if ($oldUrl != '') { // التحقق من الملف هل هو فارغ
            if (!$this->CheckExt($upfile[ext])) {
                $this->return_error('صيغة الملف المراد رفعه ممنوعة');
                return false;
            } else {
                $file = file_get_contents($oldUrl);
                if ($file) { //if بداية
                    $path = $this->_uploadfolder . "/" . $upfile[newname];
                    $fp = @fopen($path, 'w+');
                    if ($fp) {
                        $Write = @fwrite($fp, $file);
                        if ($Write) {
                            $upfile['fileurl'] = $GLOBALS['Config']['Tools']['script_path'] .
                                $this->_uploadurl . '/' . $upfile[newname];
                            $upfile['size'] = filesize($this->_uploadfolder .
                                "/" . $this->tmpName);
                            //$thumbs = $this->createthumb($upfile[place] . $upfile[newname], $upfile[ext], $upfile[thplace], 100, 100);
                            //50x50
                            $thumbs = $this->createthumb($path, $upfile[ext], $upfile[thplace] .
                                '50x50_' . $upfile[newname], 50, 50);
                            //100x100
                            $thumbs = $this->createthumb($path, $upfile[ext], $upfile[thplace] .
                                '100x100_' . $upfile[newname], 100, 100);
                            //300x200
                            $thumbs = $this->createthumb($path, $upfile[ext], $upfile[thplace] .
                                '300x200_' . $upfile[newname], 300, 200);
                            //200x300
                            $thumbs = $this->createthumb($path, $upfile[ext], $upfile[thplace] .
                                '200x300_' . $upfile[newname], 200, 300);

                            // if php can't create image thumbs
                            if (!$thumbs) {
                                // Delete the original file and the thumbs file
                                @unlink($upfile[place] . $upfile[newname]);
                                @unlink($upfile[thplace]);

                                // return error
                                $this->return_error('لم يستطع تكوين صورة مصغرة');

                                return (false);
                            }
                            $this->_urlinfo = $upfile;
                            return true;
                        } else {
                            $this->return_error('لم يتمكن من الكتابة إلى الملف : ' .
                                $this->_uploadfolder . "/" . $this->tmpName);
                            return false;
                        }
                    } else {
                        $this->return_error('لم يتمكن من فتح الملف : ' . $this->
                            _uploadfolder . "/" . $this->tmpName);
                        return false;
                    }
                } else {
                    $this->return_error('لم يتمكن من تحميل الملف : ' . $oldUrl);
                    return false;
                }
            }
        } else {
            $this->return_error('يتوجب عليك إختيار رابط ملف لتحميله');
        }
    }

    function multiupload()
    {
        if ($_FILES['attachments']['name']) {
            if (isset($_FILES['attachments']['name'][0]) and $_FILES['attachments']['name'][0] !=
                '') {
                $final = array();
                $_return = array();
                for ($x = 0; $x <= count($_FILES['attachments']['name']); $x++) {
                    //get file name
                    $file[name] = addslashes($_FILES['attachments']["name"][$x]);
                    //get file type
                    $file[type] = $_FILES['attachments']['type'][$x];
                    //get filesize in Byte
                    $file[size] = $_FILES['attachments']['size'][$x];
                    //get file tmp path
                    $file[tmp] = $_FILES['attachments']['tmp_name'][$x];
                    //get file ext [to get max uploades size]
                    $file[ext] = $this->GetExt($_FILES['attachments']["name"][$x]);
                    //print_r($file);
                    //check if guest have selected file or not
                    if ($file[name] != '') {
                        //Start Uploading File
                        $upfile = $this->Upload_File($file);
                        //if uploading successfully
                        if ($upfile) {
                            //make clean array with file data
                            $final["name"] = $upfile[name];
                            $final["uploadtime"] = time();
                            $final["size"] = $upfile[size];
                            $final["mimetype"] = $upfile[type];
                            $final["ext"] = $upfile[ext];
                            $final["filecode"] = $upfile[uniqname];
                            $final["newname"] = $upfile[newname];
                            $final["place"] = $upfile[place];
                            $final["thplace"] = $upfile[thplace];
                            $final["fileurl"] = $GLOBALS['Config']['Tools']['script_path'] .
                                $this->_uploadurl . '/' . $upfile[newname];
                            $final["filegroup"] = $upfile[group];
                            $final["error"] = '';
                            $_return[] = $final;
                        } //uploading error
                        else {
                            $_return["error"] = join('<br />', $this->
                            showErrors());
                        }
                    }
                }
            } else {
                $_return["error"] = 'لم يتم إختيار ملف لرفعه';
            }
        } else {
            $_return["error"] = 'لم يتم إختيار ملف لرفعه';
        }
        $this->_fileinfo = $_return;
        return true;
    }

    public function hasErrors()
    {
        if (count($this->_error) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Upload File
     * @param    array    file info array #note : this array content data from $_FILES array
     *                    just have this key [type,name,size,tmp]
     * @param    int        max size
     * @return    full file info array in success OR FALSE in failure
     */
    public function Upload_File($filearray = array(
        'name' => '',
        'type' => '',
        'size' => ''))
    {
        //check the right data
        if (is_array($filearray) or !is_null($filearray[type]) or !is_null($filearray[name]) or
            !is_null($filearray[tmp]) or !is_null($filearray[size])) {
            //get file ext
            $filearray[ext] = $this->GetExt($filearray[name]);
            //generate new file key
            $filearray[uniqname] = $this->uniqname();
            //make file new name
            $filearray[newname] = $this->_nameprefix . $filearray[uniqname] .
                "." . $filearray[ext];
            //the full path to move file
            $filearray[place] = $this->_uploadfolder . "/others/";
            // assign file array to var
            $this->_fileinfo = $filearray;
            // check the file ext is allowed or not
            if (!$this->CheckExt($this->_fileinfo[ext])) {
                //return error if file ext is not allowed
                $this->return_error('نوع الملف [ ' . $this->_fileinfo[ext] .
                    ' ] غير مسموح برفعه <br /> أنواع الملفات المسموح برفعها : <br /><font color="red">' .
                    join(' , ', $this->_allowext) . '<font>');
            }
            /*
            * check the file protection some hakers change file ext to other ext like
            * phpfile.jpg
            * to upload it this function not allowed to change file ext we check the right mime type
            */
            if (!$this->protection($this->_fileinfo[type], $this->_fileinfo[name],
                $filearray[tmp])) {
                // return error if the mime type of the file ext neq the file mime type
                $this->return_error('نوع الملف [ ' . $this->_fileinfo[type] .
                    ' ] غير مسموح برفعها لبعض الأسباب الأمنية');
            }
            // if count error eq 0
            if (!$this->hasErrors()) {
                // move uploaded file to upload folder
                $up = $this->move_uploaded($this->_fileinfo[tmp], $this->
                _fileinfo[place], $this->_fileinfo[newname]);
                // if success move
                if ($up) {
                    // return the full file info
                    return ($this->_fileinfo);
                } else {
                    // if can't move file
                    $this->return_error('حدث خطأ أثناء رفع الملف , رمز الخطأ : Err_u153');
                    return (false);
                }
            } else {
                // if upload file has error
                $this->return_error('حدث خطأ أثناء رفع الملف , رمز الخطأ : Err_u152');
                return (false);
            }
        } else {
            // if have error in function param
            $this->return_error('نقص في معطيات الدالة');
            return (false);
        }
    }

    public function Upload_Picture($filearray = array(
        'name' => '',
        'type' => '',
        'size' => ''))
    {
        //check the right data
        if (is_array($filearray) or !is_null($filearray[type]) or !is_null($filearray[name]) or
            !is_null($filearray[tmp]) or !is_null($filearray[size])) {
            //get file ext
            $filearray[ext] = $this->GetExt($filearray[name]);
            //generate new file key
            $filearray[uniqname] = $this->uniqname();
            //make file new name
            $filearray[newname] = $this->_nameprefix . $filearray[uniqname] .
                "." . $filearray[ext];
            //the full path to move file
            $filearray[place] = $this->_uploadfolder . "/";
            $filearray[thplace] = $this->_uploadfolder . "/thumbs/";
            // assign file array to var
            $this->_fileinfo = $filearray;
            // check the file ext is allowed or not
            if (!$this->CheckExt($this->_fileinfo[ext])) {
                //return error if file ext is not allowed
                $this->return_error('نوع الملف [ ' . $this->_fileinfo[ext] .
                    ' ] غير مسموح برفعه <br /> أنواع الملفات المسموح برفعها : <br /><font color="red">' .
                    join(' , ', $this->_allowext) . '<font>');
            }
            /*
            * check the file protection some hakers change file ext to other ext like
            * phpfile.jpg
            * to upload it this function not allowed to change file ext we check the right mime type
            */
            if (!$this->protection($this->_fileinfo[type], $this->_fileinfo[name],
                $filearray[tmp])) {
                // return error if the mime type of the file ext neq the file mime type
                $this->return_error('نوع الملف [ ' . $this->_fileinfo[type] .
                    ' ] غير مسموح برفعها لبعض الأسباب الأمنية');
            }
            // if count error eq 0
            if (!$this->hasErrors()) {
                // move uploaded file to upload folder
                $up = $this->move_uploaded($this->_fileinfo[tmp], $this->
                _fileinfo[place], $this->_fileinfo[newname]);
                // if success move
                if ($up) {
                    // return the full file info

                    //50x50
                    $thumbs = $this->createthumb($this->_fileinfo[place] . $this->
                        _fileinfo[newname], $this->_fileinfo[ext], $this->
                        _fileinfo[thplace] . '50x50_' . $filearray[newname], 50,
                        50);
                    if (!$thumbs) {
                        // Delete the original file and the thumbs file
                        @unlink($this->_fileinfo[place] . $this->_fileinfo[newname]);
                        @unlink($this->_fileinfo[thplace] . '50x50' . $filearray[newname]);
                        // return error
                        $this->return_error('لم يستطع تكوين صورة مصغرة');
                        return (false);
                    }
                    //100x100
                    $thumbs = $this->createthumb($this->_fileinfo[place] . $this->
                        _fileinfo[newname], $this->_fileinfo[ext], $this->
                        _fileinfo[thplace] . '100x100_' . $filearray[newname],
                        100, 100);
                    if (!$thumbs) {
//                        // Delete the original file and the thumbs file
//                        @unlink($this->_fileinfo[place] . $this->_fileinfo[newname]);
//                        @unlink($this->_fileinfo[thplace] . '50x50' . $filearray[newname]);
//                        @unlink($this->_fileinfo[thplace] . '100x100' . $filearray[newname]);
//                        // return error
//                        $this->return_error('لم يستطع تكوين صورة مصغرة');
//                        return (false);
                    }
                    $thumbs = $this->createthumb($this->_fileinfo[place] . $this->
                        _fileinfo[newname], $this->_fileinfo[ext], $this->
                        _fileinfo[thplace] . '300x200_' . $filearray[newname], 300, 200);
                    //200x300
                    $thumbs = $this->createthumb($this->_fileinfo[place] . $this->
                        _fileinfo[newname], $this->_fileinfo[ext], $this->
                        _fileinfo[thplace] .
                        '200x300_' . $filearray[newname], 200, 300);
                    $this->ReduceRes($this->_fileinfo[place] . $this->_fileinfo[newname],
                        $this->_fileinfo[ext]);

                    // if allow print image logo
                    if ($this->_logoimages == true) {
                        // print logo to image
                        $this->printlogo($this->_fileinfo[place] . $this->
                            _fileinfo[newname], $this->_fileinfo[ext], $GLOBALS['Config']['Tools']['script_path'] .
                            'img/logo.png');
                    }

                    return ($this->_fileinfo);
                } else {
                    // if can't move file
                    $this->return_error('حدث خطأ أثناء رفع الملف , رمز الخطأ : Err_u153');
                    return (false);
                }
            } else {
                // if upload file has error
                $this->return_error('حدث خطأ أثناء رفع الملف , رمز الخطأ : Err_u152');
                return (false);
            }
        } else {
            // if have error in function param
            $this->return_error('نقص في معطيات الدالة');
            return (false);
        }
    }

    public function ReduceRes($name, $ext)
    {
        if (preg_match("/jpg|jpeg/", $ext)) {
            $src_img = @imagecreatefromjpeg($name);

            if (!$src_img) {
                return (false);
            }
        }
        if (preg_match("/png/", $ext)) {
            return true;
            $src_img = imagecreatefrompng($name);

            if (!$src_img) {
                return (false);
            }
        }
        if (preg_match("/gif/", $ext)) {
            $src_img = imagecreatefromgif($name);

            if (!$src_img) {
                return (false);
            }
        }

        $old_x = imageSX($src_img);
        $old_y = imageSY($src_img);
        $dst_img = ImageCreateTrueColor($old_x, $old_y);
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $old_x, $old_y, $old_x,
            $old_y);
        unlink($name);
        if (preg_match("/jpg|jpeg/", $ext)) {
            imagejpeg($dst_img, $name, 80);
        }

        if (preg_match("/png/", $ext)) {
            imagepng($dst_img, $name, 8);
        }

        if (preg_match("/gif/", $ext)) {
            imagegif($dst_img, $name, 80);
        }

        imagedestroy($dst_img);
        imagedestroy($src_img);

        return (true);
    }

    public function createthumb3($name, $ext, $filename, $new_w, $new_h)
    {
        if (is_null($name) || is_null($ext) || is_null($filename) || is_null($new_w) ||
            is_null($new_h) || !function_exists('gd_info')) {
            $this->return_error("خطأ في معطيات تكوين صورة مصغرة");
            return (false);
        }
        if (preg_match("/gif/", $ext)) {
            $imgt = "ImageGIF";
            $imgcreatefrom = "ImageCreateFromGIF";
        } else
            if (preg_match("/jpg|jpeg/", $ext)) {
                $imgt = "ImageJPEG";
                $imgcreatefrom = "ImageCreateFromJPEG";
            } else
                if (preg_match("/png/", $ext)) {
                    $imgt = "ImagePNG";
                    $imgcreatefrom = "ImageCreateFromPNG";
                }
        if ($imgt) {
            $img = $imgcreatefrom($name);
            // keep aspect ratio with these operations...
            /** $new_width = floor($width * ($thumbHeight / $height));
             * $new_height = $thumbHeight; **/
            $old_x = imageSX($img);
            $old_y = imageSY($img);

            $tmp_img = imagecreatetruecolor($new_width, $new_height);
            if (preg_match("/png/", $ext)) {
                // Disable alpha mixing and set alpha flag if is a png file
                imagealphablending($tmp_img, false);
                imagesavealpha($tmp_img, true);
            }
            imagecopyresampled($tmp_img, $src_img, 0, 0, 0, 0, $new_w, $new_h, $old_x,
                $old_y);
            $imgt($tmp_img, $filename);
            imagedestroy($tmp_img);
            imagedestroy($img);
            return (true);
        } else {
            $this->return_error("حدث خطأ غير معروف أثناء تكوين صورة مصغرة");
            return (false);
        }
    }

    /** Newer **/
    function image_resize($src, $dst, $width, $height, $crop = 0)
    {
        if (!list($w, $h) = getimagesize($src)) {
            $this->return_error("صيغة الملف المرفوعة غير مدعومة !");
            return (false);
        }
        $type = strtolower(substr(strrchr($src, "."), 1));
        if ($type == 'jpeg')
            $type = 'jpg';
        switch ($type) {
            case 'bmp':
                $img = imagecreatefromwbmp($src);
                break;
            case 'gif':
                $img = imagecreatefromgif($src);
                break;
            case 'jpg':
                $img = imagecreatefromjpeg($src);
                break;
            case 'png':
                $img = imagecreatefrompng($src);
                break;
            default:
                $this->return_error("عفواً ولكن حدث خطأ أثناء معالجة الصورة المرفوعة");
                return (false);
        }

        // resize
        if ($crop) {
            if ($w < $width or $h < $height) {
                $this->return_error("مقاس الصورة المرفوعة صغير للغاية");
                return (false);
            }
            $ratio = max($width / $w, $height / $h);
            $h = $height / $ratio;
            $x = ($w - $width / $ratio) / 2;
            $w = $width / $ratio;
        } else {
            if ($w < $width and $h < $height) {
                $this->return_error("مقاس الصورة المرفوعة صغير للغاية");
                return (false);
            }
            $ratio = min($width / $w, $height / $h);
            $width = $w * $ratio;
            $height = $h * $ratio;
            $x = 0;
        }

        $new = imagecreatetruecolor($width, $height);

        // preserve transparency
        if ($type == "gif" or $type == "png") {
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0,
                127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }

        imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

        switch ($type) {
            case 'bmp':
                imagewbmp($new, $dst);
                break;
            case 'gif':
                imagegif($new, $dst);
                break;
            case 'jpg':
                imagejpeg($new, $dst);
                break;
            case 'png':
                imagepng($new, $dst);
                break;
        }
        return true;
    }

    public function createthumb($pathToImage, $ext, $filename, $new_w, $new_h)
    {

        return $this->image_resize($pathToImage, $filename, $new_w, $new_h, 1);
        /*global $ImageResize;
        $ImageResize->int_class($pathToImage);
        $ImageResize->resizeToWidth($new_w);
        $thumbContent = $ImageResize->save($filename);
        return true;*/
    }

    /** New **/
    public function createthumb5($name, $ext, $filename, $new_w, $new_h)
    {
        ini_set('gd.jpeg_ignore_warning', 1);
        if (!is_null($name) and !is_null($ext) and !is_null($filename) and !
            is_null($new_w) and !is_null($new_h) and function_exists('gd_info')) {

            if (preg_match("/jpg|jpeg/", $ext)) {
                $src_img = @imagecreatefromjpeg($name);

                if (!$src_img) {
                    $this->return_error("خطأ أثناء تكوين صورة مصغرة: JPG");
                    return (false);
                }
            }
            if (preg_match("/png/", $ext)) {
                try {
                    $src_img = @imagecreatefrompng($name);
                } catch (exception $e) {
                    $this->return_error("خطأ أثناء تكوين صورة مصغرة\n" . $e->
                        getMessage());
                    return false;
                }
            }
            if (preg_match("/gif/", $ext)) {
                $src_img = imagecreatefromgif($name);

                if (!$src_img) {
                    $this->return_error("خطأ أثناء تكوين صورة مصغرة: GIF");
                    return (false);
                }
            }

            $old_x = imageSX($src_img);
            $old_y = imageSY($src_img);

            $thumb_w = $new_w;
            $thumb_h = $new_h;
            $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
            if (preg_match("/png/", $ext)) {
                // Disable alpha mixing and set alpha flag if is a png file
                imagealphablending($dst_img, false);
                imagesavealpha($dst_img, true);
            }
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h,
                $old_x, $old_y);

            if (preg_match("/jpg|jpeg/", $ext)) {
                imagejpeg($dst_img, $filename);
            }

            if (preg_match("/png/", $ext)) {
                //$background = imagecolorallocate($dst_img, 0, 0, 0);
                imagepng($dst_img, $filename);
            }

            if (preg_match("/gif/", $ext)) {
                imagegif($dst_img, $filename);
            }

            imagedestroy($dst_img);
            imagedestroy($src_img);

            return (true);
        } else {
            $this->return_error("خطأ في معطيات تكوين صورة مصغرة");
            return (false);
        }
    }

    /** Old **/
    public function createthumb2($name, $ext, $filename, $new_w, $new_h)
    {
        ini_set('gd.jpeg_ignore_warning', 1);
        if (!is_null($name) and !is_null($ext) and !is_null($filename) and !
            is_null($new_w) and !is_null($new_h) and function_exists('gd_info')) {

            if (preg_match("/jpg|jpeg/", $ext)) {
                $src_img = @imagecreatefromjpeg($name);

                if (!$src_img) {
                    $this->return_error("خطأ أثناء تكوين صورة مصغرة: JPG");
                    return (false);
                }
            }
            if (preg_match("/png/", $ext)) {
                try {
                    $src_img = @imagecreatefrompng($name);
                    imagecolortransparent($src_img, $background);
                    imagealphablending($src_img, false);
                    imagesavealpha($src_img, true);
                } catch (exception $e) {
                    $this->return_error("خطأ أثناء تكوين صورة مصغرة\n" . $e->
                        getMessage());
                    return false;
                }
            }
            if (preg_match("/gif/", $ext)) {
                $src_img = imagecreatefromgif($name);

                if (!$src_img) {
                    $this->return_error("خطأ أثناء تكوين صورة مصغرة: GIF");
                    return (false);
                }
            }

            $old_x = imageSX($src_img);
            $old_y = imageSY($src_img);

            $thumb_w = $new_w;
            $thumb_h = $new_h;
            $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h,
                $old_x, $old_y);

            if (preg_match("/jpg|jpeg/", $ext)) {
                imagejpeg($dst_img, $filename);
            }

            if (preg_match("/png/", $ext)) {
                $background = imagecolorallocate($dst_img, 0, 0, 0);
                imagepng($dst_img, $filename);
            }

            if (preg_match("/gif/", $ext)) {
                imagegif($dst_img, $filename);
            }

            imagedestroy($dst_img);
            imagedestroy($src_img);

            return (true);
        } else {
            $this->return_error("خطأ في معطيات تكوين صورة مصغرة");
            return (false);
        }
    }

    /**
     * GET file ext
     * @param    str    file name
     * @return    file ext in success Or False in failure
     */
    public function GetExt($filename)
    {
        // if file name is not null
        if (!is_null($filename)) {
            // make the file name lower case and crop the ext
            $fileext = strtolower(strrchr(strtolower($filename), '.'));
            // replace the dot (.) with blank
            $fileext = str_replace(".", "", $fileext);
            // return the file ext
            return ($fileext);
        } else {
            // return false if file name is null
            return (false);
        }
    }

    /**
     * generate new key
     * @param    void
     * @return    str    key
     */
    public function uniqname()
    {
        return (substr(md5(uniqid(rand())), 0, 15));
    }

    /**
     * check if file ext allow in allow ext array or not
     * @param    str    file name
     * @return    BOLL    TRUE if allowed Or FALSE
     */
    public function CheckExt($ext)
    {
        // check if ext is nul Or allow ext array is not array
        if (!is_null($ext) or !is_array($this->_allowext)) {
            // check if ext in array of allow ext
            if (in_array($ext, $this->_allowext)) {
                // return true it's mean it is allow ext
                return (true);
            } else {
                // return false it's mean it is disallow ext
                return (false);
            }
        } else {
            // return false if ext param is null or allowext it not array
            return (false);
        }
    }

    private function fixIeMIME($mime)
    {
        switch ($mime) {
            case "application/x-zip-compressed":
                return ("application/zip");
                break;
            case "image/x-png":
                return ("image/xpng");
                break;
            case "image/pjpeg":
                return ("image/jpeg");
                break;
            case "audio/x-mpeg":
            case "audio/mp3":
            case "audio/x-mp3":
            case "audio/mpeg3":
            case "audio/x-mpeg3":
            case "audio/mpg":
            case "audio/x-mpg":
            case "audio/x-mpegaudio":
                return ("audio/mpeg");
                break;
            default:
                return ($mime);
                break;
        }
    }

    /**
     * chech file protection
     * @param    str        file mime
     * @param    str        file name
     * @return    boll    TRUE mean is positive file
     */
    public function protection($file_mimetype, $file_name, $tmp = '')
    {
        //fie IE mime type
        $file_mimetype = $this->fixIeMIME($file_mimetype);
        if (!is_null($file_mimetype) and !is_null($file_name)) {
            $realmime = $file_mimetype; //$this->Get_File_MimeType($file_name, $tmp);
            if (($realmime != $file_mimetype) and ($file_mimetype !=
                    'application/octet-stream')) {
                return (false);
            } else {
                if (is_array($this->_disallow_mime)) {
                    if (in_array($file_mimetype, $this->_disallow_mime)) {
                        return (false);
                    } else {
                        return (true);
                    }
                } else {
                    return (true);
                }
            }
        } else {
            return (false);
        }
    }

    /**
     * get the mime type by ext
     * @param    str        file name with full path
     * @return    str    MIME type
     */
    public function Get_File_MimeType($filename, $tmp = '')
    {
        if (!is_null($filename)) {
            if (function_exists('finfo_open')) {
                $finfo = finfo_open(FILEINFO_MIME);
                $mimetype = finfo_file($finfo, $filename);
                finfo_close($finfo);
                return $mimetype;
            } else {
                $mime_types = array(
                    'txt' => 'text/plain',
                    'htm' => 'text/html',
                    'html' => 'text/html',
                    'php' => 'text/html',
                    'css' => 'text/css',
                    'js' => 'application/javascript',
                    'json' => 'application/json',
                    'xml' => 'application/xml',
                    'swf' => 'application/x-shockwave-flash',
                    'flv' => 'video/x-flv', // images
                    'png' => 'image/png',
                    'jpe' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'jpg' => 'image/jpeg',
                    'gif' => 'image/gif',
                    'bmp' => 'image/bmp',
                    'ico' => 'image/vnd.microsoft.icon',
                    'tiff' => 'image/tiff',
                    'tif' => 'image/tiff',
                    'svg' => 'image/svg+xml',
                    'svgz' => 'image/svg+xml', // archives
                    'zip' => 'application/zip',
                    'rar' => 'application/x-rar-compressed',
                    'exe' => 'application/x-msdownload',
                    'msi' => 'application/x-msdownload',
                    'cab' => 'application/vnd.ms-cab-compressed', // audio/video
                    'mp3' => 'audio/mpeg',
                    'qt' => 'video/quicktime',
                    'mov' => 'video/quicktime',
                    'wmv' => 'video/x-ms-wmv',
                    'avi' => 'video/x-msvideo',
                    'wav' => 'audio/x-wav',
                    'ram' => 'audio/x-pn-realaudio',
                    '3gp' => 'video/3gpp',
                    'ra' => 'audio/vnd.rn-realaudio',
                    'ram' => 'audio/vnd.rn-realaudio',
                    'rm' => 'application/vnd.rn-realmedia',
                    'rpm' => 'audio/x-pn-realaudio-plugin', // adobe
                    'pdf' => 'application/pdf',
                    'psd' => 'image/vnd.adobe.photoshop',
                    'ai' => 'application/postscript',
                    'eps' => 'application/postscript',
                    'ps' => 'application/postscript', // ms office
                    'doc' => 'application/msword',
                    'rtf' => 'application/rtf',
                    'xls' => 'application/vnd.ms-excel',
                    'ppt' => 'application/vnd.ms-powerpoint',
                    // open office
                    'odt' => 'application/vnd.oasis.opendocument.text',
                    'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
                    'docx' =>
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                );
                $ext = $this->GetExt($filename);
                if (array_key_exists($ext, $mime_types)) {
                    return $mime_types[$ext];
                } elseif (function_exists('mime_content_type')) {
                    return (mime_content_type($tmp));
                } else {
                    return 'application/octet-stream';
                }
            }
        } else {
            return (false);
        }
    }

    private function return_error($message)
    {
        return $this->_error[] = $message;
    }

    /**
     * move uploaded file
     * @param    str        file tmp
     * @param    str        new file place
     * @param    str        new file name
     * @return    boll    TRUE it's success moved
     */
    private function move_uploaded($tmp, $path, $name)
    {
        // check if all param is not null
        if (!is_null($tmp) or !is_null($path) or !is_null($name)) {
            // check if  is writeable dir or not
            if (is_dir($path) and is_writeable($path)) {
                // move file to file place
                $movefile = @move_uploaded_file($tmp, $path . $name);
                // if success move
                if ($movefile) {
                    return (true);
                } else {
                    // if php can't move file
                    return (false);
                }
            } else {
                // if uploaded dir is not 	writeable
                return (false);
            }
        } else {
            // if  param is null
            return (false);
        }
    }

    public function __destruct()
    {
        $this->_allowext = null;
        $this->_logoimages = false;
        $this->_th_width = null;
        $this->_th_hight = null;
        $this->_nameprefix = null;
        $this->_maxsize = null;
        $this->_error = null;
        $this->_fileinfo = null;
        $this->_disallow_mime = null;
        $this->_logopath = null;
        $this->_uploadfolder = null;
    }

    public function showErrors()
    {
        if ($this->hasErrors()) {
            reset($this->_error);
            return ($this->_error);
            $this->resetErrors();
        }
    }

    private function resetErrors()
    {
        if ($this->hasErrors()) {
            unset($this->_error);
            $this->_error = array();
        }
    }

    public function printlogo($name, $ext, $logo)
    {

        if (!is_null($name) and !is_null($ext) and !is_null($logo) and
            function_exists('gd_info')) {

            if (preg_match("/jpg|jpeg/", $ext)) {
                $src_img = imagecreatefromjpeg($name);

                if (!$src_img) {
                    return (false);
                }
            }
            if (preg_match("/png/", $ext)) {
                $src_img = imagecreatefrompng($name);

                if (!$src_img) {
                    return (false);
                }
            }

            if (preg_match("/gif/", $ext)) {
                $src_img = imagecreatefromgif($name);

                if (!$src_img) {
                    return (false);
                }
            }

            $src_logo = imagecreatefrompng($logo);

            $bwidth = imageSX($src_img);
            $bheight = imageSY($src_img);
            $lwidth = imageSX($src_logo);
            $lheight = imageSY($src_logo);

            if ($bwidth > 160 && $bheight > 130) {

                $src_x = $bwidth - ($lwidth + 5);
                $src_y = $bheight - ($lheight + 5);
                ImageAlphaBlending($src_img, true);
                ImageCopy($src_img, $src_logo, $src_x, $src_y, 0, 0, $lwidth, $lheight);

                if (preg_match("/jpg|jpeg/", $ext)) {
                    imagejpeg($src_img, $name, 90);
                }
                if (preg_match("/png/", $ext)) {
                    imagepng($src_img, $name, 90);
                }
                if (preg_match("/gif/", $ext)) {
                    imagegif($src_img, $name, 90);
                }
            } else {
                return (false);
            }
        } else {
            return (false);
        }
    }

}

?> 