import gdown

url = 'https://drive.google.com/file/d/1Plofi09JZ6UOQH4WIfpnF2Cz9nyXbocw/view?usp=sharing'
output_path = 'module.zip'
gdown.download(url, output_path, quiet=False,fuzzy=True)