FROM node:latest

# Install dependencies
RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl

RUN mkdir "node_modules"
#install tailwind
# Change current user
USER node
EXPOSE 5173
RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www
# https://github.com/vitejs/vite/discussions/3396
CMD ["sh", "-c", "npm install && npm run dev -- --host"]
