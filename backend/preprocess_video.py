import os
import cv2
import numpy as np
from PIL import Image
from moviepy.editor import *

import sys
sys.path.append('FollowYourPose')

def get_frames(x, video_in):
    frames = []
    #resize the video
    clip = VideoFileClip(video_in)
    start_frame = 0  # 起始帧数
    end_frame = 500  # 结束帧数
    
    if not os.path.exists('./raw_frames'):
        os.makedirs('./raw_frames')
    
    if not os.path.exists('./mmpose_frames'):
        os.makedirs('./mmpose_frames')
    name = video_in.split('/')[-1]
    #check fps
    if clip.fps > 30:
        print("vide rate is over 30, resetting to 30")
        clip_resized = clip.resize(height=512)
        clip_resized = clip_resized.subclip(start_frame / clip_resized.fps, end_frame / clip_resized.fps) # subclip 2 seconds
        clip_resized.write_videofile("./video_resized.mp4", fps=30)
    else:
        print("video rate is OK")
        clip_resized = clip.resize(height=512)
        # clip_resized = clip_resized.subclip(start_frame / clip.fps, end_frame / clip.fps) # subclip 5 seconds
        clip_resized.write_videofile(f"./resized_{name}", fps=clip.fps)
    
    

if __name__ == '__main__':
    get_frames(None, "debugs/video-10.mp4")
    get_frames(None, "debugs/video-11.mp4")
    get_frames(None, "debugs/video-12-1.mp4")
    get_frames(None, "debugs/video-12-2.mp4")