<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Generator;
use GuzzleHttp\Client;

class VideoController extends Controller
{
    function test(){
        
        // $generators=Generator::all();
        // return view('test',compact('generators'));
    }

    function home(){
        $generators=Generator::orderBy('id','DESC')->paginate(5);
        return view('home',compact('generators'));
    }

    function showUploadForm(){
        return view('upload');
    }

    function upload(Request $request){

        if ($request->hasFile('inputvideo')) {
            if($request->textprompt=='') return response()->json(['error' => 'Lỗi: Chưa nhập Prompt mô tả'], 400);
            $video = $request->file('inputvideo');
            $originalName = pathinfo($video->getClientOriginalName(), PATHINFO_FILENAME);
            $videoName = $originalName . '-' .time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('videos'), $videoName);
            
            $generator= new Generator();
            $generator->description_prompt=$request->textprompt;
            $generator->inputvideo=$videoName;
            $generator->language=$request->language;
            $generator->save();
            // return redirect()->route('upload.form')->with('success', 'Upload video thành công.');

            $client = new Client();

            // Đường dẫn tới server mục tiêu
            $serverUrl = 'https://f42b-134-65-167-66.ngrok.io/'; 

            try {
                $response = $client->request('POST', $serverUrl, [
                    'multipart' => [
                        [
                            'name'     => 'id',
                            'contents' =>  $generator->id,
                        ],
                        [
                            'name'     => 'prompt',
                            'contents' => $request->textprompt,
                        ],
                        [
                            'name'     => 'video',
                            'contents' => 'https://caocanhlinh.com/videos/'.$videoName,
                        ],
                        [
                            'name'     => 'lang',
                            'contents' => $request->language,
                        ],
                    ],
                ]);

                // Xử lý response từ server mục tiêu ở đây (nếu cần)
                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();
                
                // Đóng kết nối HTTP client
                // $client->close();

            } catch (\GuzzleHttp\Exception\RequestException $e) {
                echo $e->getMessage();
            }
            return response()->json(['message' => 'Dữ liệu đã được xử lý thành công']);
        }
        
        else return response()->json(['error' => 'Lỗi: Chưa chọn file upload | file không hợp lệ'], 400);
    }

    function getdata(){
        $generator= Generator::latest('id')->first();
        $data = [
            'id' => $generator->id,
            'prompt' => $generator->description_prompt,
            'video' => url('videos/'.$generator->inputvideo),
            'lang' => $generator->language,
        ];
        return response($data)->header('Content-Type', 'application/json');
    }

    function senddata(Request $request){
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $originalName = pathinfo($video->getClientOriginalName(), PATHINFO_FILENAME);
            $videoName = $originalName . '-' .time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('results'), $videoName);

            $generator= Generator::find($request->id);
            $generator->outputvideo=$videoName;
            $generator->save();

            return "ok";
            // return response()->json(['message' => 'https://caocanhlinh.com/results/'.$videoName]);
            // return redirect()->route('upload.form')->with('success', 'Upload video thành công.');
        }
        
        else return "error!";
    }
}
