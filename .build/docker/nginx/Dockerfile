FROM nginx:latest
MAINTAINER SprintF <devops@sprintf.ru>

ARG UID
ARG GID

RUN usermod -u ${UID} www-data
RUN groupmod -g ${GID} www-data

WORKDIR /app

CMD ["nginx", "-g", "daemon off;"]
