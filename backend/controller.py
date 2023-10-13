import cv2
import torch
import base64
from module.pose_det.predict_model import PosePredict
from module.video_gen.predict_model import Diffusion
from module.lang_trans.predict_model import Translate

device = 'cuda:0' if torch.cuda.is_available() else 'cpu'

pose_det = PosePredict(device)
video_gen = Diffusion()
lang_tras = Translate()

def backend_runing(args):
    video_path, prompt, lang, step, guidance_scale= args
    try:
        print("language processing")
        prompt = lang_tras.predict(prompt, lang)
        print("process video ...")
        video_path = pose_det.predict(video_path)
        print("diffusion video ...")
        video_path = video_gen.predict(video_path, prompt, step, guidance_scale)
        return video_path
    except:
        return None
