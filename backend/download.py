import gdown
url = 'https://drive.google.com/drive/folders/18Vz7_VAyTmpkz0d6qWnRxHQQMJJHq6j5?usp=sharing'
gdown.download_folder(url, quiet=True, use_cookies=False)
