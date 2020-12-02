<?php
  
namespace App\Http\Traits;
  
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Image;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Excel;


trait HelperTraits {
    protected $request;
    public function __construct(Request $request){
        $this->request=$request;
    }
    public function singleImg(Request $request,$field,$height,$width){
        if($request->hasFile($field)){
            $img=$request->file($field);
            $title= time().'.'.$img->getClientOriginalExtension();
            $filePath=public_path('/uploads/images');
            $resize=Image::make($img);
            $resize->resize($height,$width)->save($filePath.'/'.$title);
            $m=$resize->basename;
            return $m;
        }
        // else{
        //     $val=$this->checkImg($model,$attribute1,$value1,$attribute2,$value2);
        //     return $val;
        // }   
    }

    static function UploadImage($path, $image)
  {
    $data = ['image'=>$image];
      $validate = Validator::make($data, [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
      ]);
      if (!$validate->fails()){
        $filePath = Storage::disk('public')->put("/uploads/$path/", $image);
        $_jstUp = env('STORAGE_URL') . '/' . $path . '/' . basename($filePath);
        $DIR = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        $IMG = $DIR . '/uploads/' . $path . '/' . basename($filePath);

        list($width, $height) = getimagesize($_jstUp);
        if ($width > $height) {
          $__width = 1500;
          if ($width > $__width) {
            $__height = $height * ($__width / $width);
            $img = Image::make($_jstUp);
            $img->resize((int)$__width, (int)$__height);
            $img->save($IMG);
          }
        } else {
          $__height = 1500;
          if ($height > $__height) {
            $__width = $width * ($__height / $height);
            $img = Image::make($_jstUp);
            $img->resize((int)$__width, (int)$__height);
            $img->save($IMG);
          }
        }

        return basename($filePath);
      }
  }

    public function imagesUpload($storage,$fname){
        $toStorage=$storage;
        if(request()->hasFile($fname)){   
            foreach(request()->file($fname) as $file){
                $name = $toStorage.'gallery_'.'_'.mt_rand(100,2000).time().'.'.$file->extension();
                $file->move(public_path().$toStorage, $name); 
                $data[] = $name; 
            }
            return $data;
         }
    }


    public function dynamicUpload($fname){
        $toStorage="/uploads/images";
        if(request()->hasFile($fname)){   
            foreach(request()->file($fname) as $file){
                $name = mt_rand(100,2000).time().'.'.$file->extension();
                $file->move(public_path().$toStorage, $name); 
                $data[] = $name; 
            }
            return $data;
         }
    }

    public function tinyText(Request $request,$filedName){
        if($request->input($filedName) != null){
            $detail=$request->input($filedName);
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($detail);
        $images = $dom->getElementsByTagName('img');
        foreach($images as $k => $img){
            $data = $img->getAttribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= "/uploads/images" . time().$k.'.png';
            $path = public_path() . $image_name;
            file_put_contents($path, $data);
            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
        }
        $detail = $dom->saveHTML();
        return $detail;
        }
        else{
            $detail=null;
            return $detail;
        }
    }

    public function checkImg($model,$attribute1,$value1,$attribute2,$value2){
        $get_img=$model::where($attribute,'=',$value)->where($attribute2,'=',$value2)->first();
        if($get_img == null) return false;
        else return $get_image;
    }

    public function insertData($model,$args){
        $data=$model::where('id',1)->first();
        if($data == null){
            $d=new $model;
            foreach($args as $key=>$arg){
                if(gettype($arg) ==="array"){
                    $d->$key=json_encode($this->dynamicUpload($key));
                }
                $d->$key=$arg;
            }
            $d->save();
        }
        else{
            foreach($args as $key=>$arg){
                if(gettype($arg) =="array"){
                    $data->$key=json_encode($this->dynamicUpload($key));
                }
                $data->$key=$arg;
            }
            $data->save();
        }
    }

    public function sendMail($template,$to_name,$to_email,$data,$subject,$from,$company){
        if($to_email == null){
            return response()->json('error',500);
        }
        else{
            Mail::send($template, $data, function($message) use ($to_name, $to_email,$subject,$from,$company) {
                $message->to($to_email, $to_name)->subject($subject);
                $message->from($from,$company);
            });
        }
    }

    public function send_multiple($your_email,$company,$reciepent,$subject,$data,$files){
        
        Mail::send('email.invoice', $data, function ($message) use($your_email,$company,$reciepent,$subject,$files) {
            $message->from($your_email, $company);
            $message->to(explode(',',$reciepent))->subject($subject);
            $a=(count($files));
            if($a > 0) {
                foreach($files as $file) {
                    $message->attach($file->getRealPath(), array(
                        'as' => $file->getClientOriginalName(), // If you want you can chnage original name to custom name      
                        'mime' => $file->getMimeType())
                    );
                }
            }
        });
    }

    
}