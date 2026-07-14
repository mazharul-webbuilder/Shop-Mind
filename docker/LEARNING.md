# Docker Learning Guide for Laravel (Shopmind)

This guide explains the Docker setup we created for your project. It's designed to help you understand "what is what" and prepare you for technical interviews.

---

## 1. Core Docker Concepts

### 🐋 What is Docker?
Think of Docker as a way to "package" your application with everything it needs to run (PHP, Nginx, Libraries) so it works exactly the same on your machine, your colleague's machine, or a server.

### 🖼️ Image vs. 📦 Container
- **Image**: A read-only template (like a Class in OOP). It contains the OS, PHP, and your code.
- **Container**: A running instance of an image (like an Object in OOP). You can start, stop, or delete it.

### 💾 Volumes
- **What they are**: A way to "link" a folder on your Windows machine to a folder inside the Docker container.
- **Why we use them**: 
    1. **Development**: When you change code in Windows, it instantly updates inside the container.
    2. **Data Persistence**: If you delete a database container, your data stays safe in the Windows folder (e.g., `./docker/mysql`).

### 🌐 Networks
- **What they are**: A private virtual network where containers can talk to each other.
- **Example**: In our setup, the `app` container talks to the `db` container using the name `db` instead of an IP address. Docker handles this automatically.

---

## 2. File Breakdown

### 📄 Dockerfile (The Blueprint for PHP)
This file tells Docker how to build the "PHP environment".
- `FROM php:8.4-fpm`: Starts with an official PHP image.
- `RUN apt-get update...`: Installs Linux tools like `git`, `zip`, and `curl` needed by Laravel/Composer.
- `RUN docker-php-ext-install...`: Installs PHP extensions (MySQL driver, Image processing, etc.).
- `COPY --from=composer...`: Grabs the Composer tool and puts it inside our image.
- `WORKDIR /var/www`: Sets the "Home folder" inside the container.

### 📄 docker-compose.yml (The Orchestrator)
This file manages multiple containers at once (PHP, Nginx, MySQL).
- `services`: Defines each "piece" of your app.
- `ports: "8000:80"`: Maps your computer's port 8000 to the container's port 80.
- `restart: unless-stopped`: If your computer restarts, Docker will try to start the containers again.
- `environment`: Passes `.env` variables (like DB credentials) into the container.

### 📄 nginx/default.conf (The Traffic Cop)
This file tells the Nginx web server how to handle requests.
- `root /var/www/public`: Tells Nginx where Laravel's `index.php` is.
- `fastcgi_pass app:9000`: Tells Nginx: "If the user wants a PHP file, send it to the `app` container on port 9000."

---

## 3. Your Questions Answered

### ❓ What if I use an external DB (like AWS or RDS)?
You **don't** need the `db` service in `docker-compose.yml`. 
1. Delete the `db:` section from `docker-compose.yml`.
2. Update your `.env`: Change `DB_HOST` from `db` to your external IP/URL (e.g., `123.45.67.89`).

### ❓ What if I want to add Redis?
You just add a new service to `docker-compose.yml`:
```yaml
  redis:
    image: redis:alpine
    container_name: shopmind-redis
    networks:
      - shopmind-network
```
Then in `.env`, set `REDIS_HOST=redis`.

### ❓ If I rebuild the image, will my data be gone?
**No**, as long as you use **Volumes**.
- In our `docker-compose.yml`, we mapped `./docker/mysql` to `/var/lib/mysql`.
- Even if you run `docker compose down` or rebuild the image, the actual database files stay on your Windows hard drive. When the container starts again, it "mounts" those files back.

---

## 4. Interview Tips (For Amateurs)

If an interviewer asks about Docker, mention these "Pro" points:
1. **Consistency**: "We use Docker to ensure the 'it works on my machine' problem is solved."
2. **Isolation**: "Each service (Nginx, PHP, MySQL) runs in its own container, so they don't mess with each other."
3. **Multi-stage builds** (Bonus): Mentally note that our Dockerfile is a "Development" setup because it mounts the local code. For production, we would `COPY` the code into the image for security and speed.
4. **Alpine Images**: Mention we used `nginx:alpine` because it's tiny (only ~5MB), which makes deployments faster.

---

### Useful Commands to Remember:
- `docker compose up -d`: Start everything in the background.
- `docker compose down`: Stop and remove containers.
- `docker compose ps`: See what is running.
- `docker compose exec app php artisan migrate`: Run a command inside the PHP container.
