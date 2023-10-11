docker run --rm -it \
           -v `pwd`:/server \
           --network='host' \
           --name='speech_enhancement' \
           hopny:latest bash