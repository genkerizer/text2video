import requests
from flask import Flask, request, jsonify
from werkzeug.utils import secure_filename
import os
import flask
import pickle
import numpy as np
from controller import backend_runing
from flask import Response
import socket
import urllib
from flask_ngrok import run_with_ngrok
from https_status.status_code import status_code


app = Flask(__name__)

run_with_ngrok(app) 

UPLOAD_FOLDER = 'database'
if not os.path.exists(UPLOAD_FOLDER):
    os.makedirs(UPLOAD_FOLDER)

GET_URL = "https://caocanhlinh.com/getdata"
SEND_URL = "https://caocanhlinh.com/senddata"

# Define the allowed video file extensions
ALLOWED_EXTENSIONS = {'mp4', 'avi', 'mkv', 'mov', 'wmv'}

# Define the directory where uploaded videos will be stored

# Function to check if a file has an allowed extension
def allowed_file(filename):
    extension = filename.split('.')[-1]
    return True if extension in ALLOWED_EXTENSIONS else False

class VideoTextAPI:
    def __init__(self):
        pass
    
    @staticmethod
    def video_process():
        if 'video' not in request.files:
            return None, status_code['401']
        
        video = request.files['video']
        filename = video.filename
        if filename == '':
            return None, None, status_code['402']
        
        if not allowed_file(filename):
            return None, None,status_code['405']

        return video, filename, {}
    

    @staticmethod
    def request_process():
        data = requests.get(GET_URL).json()
        return data

    
    @staticmethod
    def prompt_process(prompt):
        if not isinstance(prompt, str):
            return None
        if len(prompt) == 0:
            return None
        return prompt


    @staticmethod
    def download_file(video_url):
        try:
            name = video_url.split('/')[-1]
            data = requests.get(video_url, timeout=10, stream=True)
            save_local_path = os.path.join(UPLOAD_FOLDER, name)
            with open(save_local_path, 'wb') as fh:
                for chunk in data.iter_content(1024 * 1024):
                    fh.write(chunk)
            return save_local_path
        except:
            return None
        
    @staticmethod
    def sendfile(video_path, id):
        name = video_path.split('/')[-1]
        payload={'id': id}
        files=[
        ('video',(name , open(video_path,'rb'),'application/octet-stream'))]
        headers = {}
        response = requests.request("POST", SEND_URL, headers=headers, data=payload, files=files)
        return response
    
    @staticmethod
    def process():
        try:
            if request.method == 'POST':
                id_ = request.form["id"]
                prompt = request.form["prompt"]
                video_url = request.form["video"]
                lang = request.form["lang"]
                step = request.form["step"]
                guidance_scale = request.form["guidance_scale"]
            else:
                id_ = request.args.get("id")
                prompt = request.args.get("prompt")
                video_url = request.args.get("video")
                lang = request.args.get("lang")
                step = request.args.get["step"]
                guidance_scale = request.args.get["guidance_scale"]

            prompt = VideoTextAPI.prompt_process(prompt)
            if prompt is None:
                jsonify(status_code['404'])

            save_local_path = VideoTextAPI.download_file(video_url)
            if save_local_path is None:
                return jsonify(status_code['402'])
            video_path = backend_runing([save_local_path, prompt, int(lang), step, guidance_scale])
            result = VideoTextAPI.sendfile(video_path, int(id_))
            if result is None:
                return jsonify(status_code['500'])
            if result.status_code == 200:
                return jsonify(status_code['200'])
            else:
                return jsonify(status_code['500'])
        except: 
            return jsonify(status_code['500'])
  
app.add_url_rule('/', methods=['GET', 'POST'], view_func=VideoTextAPI.process)
if __name__ == '__main__':
    app.run()

    