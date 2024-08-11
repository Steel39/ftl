FROM node:latest

# Install dependencies
RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl


#install tailwind
# Change current user
RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www
USER www
EXPOSE 5173

# https://github.com/vitejs/vite/discussions/3396
CMD ["sh", "-c", "npm install && npm run dev -- --host"]
