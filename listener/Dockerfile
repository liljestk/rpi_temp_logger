FROM node:21

RUN apt-get update

RUN apt-get install git

WORKDIR /listener

COPY /listener/package-lock.json ./

RUN npm install --quiet mqtt fs mysql

COPY . .

CMD [ "node", "client.js" ]
