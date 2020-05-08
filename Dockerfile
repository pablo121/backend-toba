FROM siutoba/docker-web:latest
MAINTAINER leo.garay@gmail.com

COPY proyecto.sh /entrypoint.d/
COPY crontab.sh /.

RUN apt-get update -qq && apt-get install -y cron && \
 	chmod +x /crontab.sh && \
    (crontab -l 2>/dev/null; echo "*/10 * * * * /crontab.sh") | crontab -

RUN chmod +x /entrypoint.d/*.sh