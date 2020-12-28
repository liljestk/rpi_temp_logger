FROM node:15

RUN apt-get update

RUN apt-get install git

WORKDIR /listener

COPY /listener/package-lock.json ./

RUN npm install --quiet

COPY . .

CMD [ "node", "client.js" ]