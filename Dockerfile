FROM siutoba/docker-web:latest
MAINTAINER leo.garay@gmail.com

RUN echo "copiando*******";
COPY proyecto.sh /entrypoint.d/
RUN ls -al /entrypoint.d/
COPY crontab.sh /.

#RUN apt-get update -qq && apt-get install -y cron dos2unix && \
# 	chmod +x /crontab.sh && \
#    (crontab -l 2>/dev/null; echo "*/10 * * * * /crontab.sh") | crontab -
#RUN dos2unix /entrypoint.d/proyecto.sh
RUN chmod +x /entrypoint.d/*.sh