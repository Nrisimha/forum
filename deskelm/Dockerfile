FROM node:latest


ENV NPM_CONFIG_PREFIX=/home/node/.npm-global

USER node

RUN mkdir ~/.npm-global \
    && mkdir ~/app \
    && npm install -g elm

WORKDIR /home/node/app

CMD yarn client


