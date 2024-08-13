FROM node:latest

# Install dependencies
RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl


#install tailwind

RUN npm install
# Change current user
RUN useradd -u 1001 -ms /bin/bash -g www node
USER 1001
EXPOSE 5173

# https://github.com/vitejs/vite/discussions/3396
CMD ["sh", "-c", "npm install -D tailwindcss", "npx tailwindcss init",  "npm run build -- --host"]
