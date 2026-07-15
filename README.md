# ShopMind 🛍️ - AI-Powered Shopping Assistant

ShopMind is a specialized Laravel-based application featuring an advanced AI Shop Assistant. While the e-commerce interface provides a realistic shopping environment, the core functionality focuses on a fully-featured AI chatbot that possesses complete knowledge of the product catalog.

Users can interact with the AI to inquire about product names, prices, and detailed descriptions, all powered by Groq AI's high-performance LLMs.

## 🚀 Key Features

*   **Smart AI Shop Assistant:** A fully integrated chat widget powered by Groq AI (`llama-3.1-8b-instant`).
*   **Deep Product Knowledge:** The AI is trained (via system prompts) on real product data including names, exact pricing, and rich descriptions.
*   **Realistic Product Database:** Utilizes Laravel Seeders and Factories to populate a comprehensive MySQL database with life-like product information.
*   **Modern UI:** Built with Tailwind CSS for a responsive, clean, and minimalist user interface.
*   **Dockerized Environment:** Fully containerized setup for consistent development and deployment.

> **Note:** This project is a demonstration of AI integration. Standard e-commerce features (cart, checkout, payments) are not functional.

## 🛠️ Tech Stack

*   **Backend:** Laravel 11+
*   **AI Engine:** Groq Cloud API
*   **Database:** MySQL
*   **Frontend:** Blade Templates & Tailwind CSS
*   **Containerization:** Docker & Docker Compose

## 💻 Installation & Setup

Ensure you have [Docker](https://www.docker.com/) and [Docker Compose](https://docs.docker.com/compose/) installed on your machine.

### 1. Clone the repository
```bash
git clone https://github.com/mazharul-webbuilder/Shop-Mind.git
cd Shop-Mind
```

### 2. Environment Configuration
Copy the example environment file and configure your Groq API key.
```bash
cp .env.example .env
```
Edit `.env` and configure your settings:
```env
GROQ_API_KEY=your_groq_api_key
GROQ_MODEL=llama-3.1-8b-instant
```

### 3. Build and Start Docker Containers
```bash
docker-compose up -d --build
```

### 4. Application Initialization
Run the following commands to set up the database and generate keys:
```bash
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed --class=ProductSeeder
docker-compose exec app npm install
docker-compose exec app npm run build
```

The application should now be accessible at `http://localhost:8000`.

## 🤖 AI Capabilities

The assistant is configured to:
*   Identify and describe any product in the store.
*   Provide accurate pricing as defined in the database.
*   Offer a friendly and concise conversational experience.
*   Stay focused on product-related inquiries.
