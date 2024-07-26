

# Barangay Queue System API

Welcome to the Barangay Queue System API project! This project provides a robust and efficient backend solution for managing barangay queues, utilizing the Lumen PHP framework, WebSocket for real-time communication, Docker for containerization, and Nginx for web serving.

## Features

- **Lumen Framework:** Lightweight and fast PHP micro-framework for building the API.
- **WebSocket Support:** Real-time updates and notifications for queue status and changes.
- **Unit Testing:** Comprehensive testing suite integrated into the Git workflow to ensure code reliability.
- **Dockerized Environment:** Easy setup and consistent environments using Docker.
- **Nginx Container:** Serves the application with improved performance and scalability.

## Technical Stack

- **Backend Framework:** Lumen PHP
- **Real-Time Communication:** WebSocket
- **Containerization:** Docker
- **Web Server:** Nginx
- **Version Control & CI/CD:** Git with unit testing and automated workflows

## Installation

### Prerequisites

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Setup

1. **Clone the Repository:**

   ```bash
   git clone <https://github.com/jaydavid1996/queueing-micro-api.git>
   cd <repository-directory>
   ```

2. **Build and Run Docker Containers:**

   ```bash
   docker-compose up --build
   ```

   This command will build the Docker images and start the containers for the API and Nginx server.

3. **Access the API:**

   Once the containers are up and running, the API will be accessible at `http://localhost:8000` or the specified port in your `docker-compose.yml` file.

## WebSocket Integration

- **WebSocket Endpoint:** The WebSocket server runs alongside the API, providing real-time updates on queue status. Ensure your client connects to the WebSocket server to receive these updates.

## Running Tests

To ensure the API's functionality and stability, unit tests are included. Run the tests using:

```bash
docker-compose exec app ./vendor/bin/phpunit
```

This command runs the test suite within the Docker container.

## Git Workflow

- **Branching:** Use feature branches for new developments. Merge changes into the `main` branch after passing tests.
- **Pull Requests:** Create pull requests for code reviews before merging changes.

## Contributing

We welcome contributions to improve the Barangay Queue System API. Please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or fix.
3. Commit your changes and push to your fork.
4. Open a pull request against the `main` branch.

Refer to the [CONTRIBUTING.md](CONTRIBUTING.md) for detailed guidelines.

## License

This project is licensed under the [MIT License](LICENSE). See the LICENSE file for more details.

## Contact

For any questions or support, please reach out to [jaydavid1996@gmail.com](mailto:jaydavid1996@gmail.com).

---

Feel free to modify the placeholders such as `<https://github.com/jaydavid1996/queueing-micro-api.git>`, `<repository-directory>`, and `[jaydavid1996@gmail.com]` as per your actual project details.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


# Docker and Docker Compose

[![Installation](https://www.svgrepo.com/show/349342/docker.svg)](https://gist.github.com/martinsam16/4492957e3bbea34046f2c8b49c3e5ac0)

For Docker Setup
! Run "docker-compose up"

# Permission Documentation

https://spatie.be/docs/laravel-permission/v5/basic-usage/basic-usage

# Serve Command
! composer run start

# Path to Swagger documentation

! {APP_URL}/api/documentation

# Installation Socket IO on Backend Side
```
npm install
```

# Installation Socket IO on Fronted Side
```
npm install socket.io-client --save
```


# Serving Socket IO
! node socket.js

# Sample Project



```
app.component.ts
```

```
importing the library
```
```typescript
import { io } from 'socket.io-client';
```

```
connecting to websocket
```
```typescript
// Token is from the authentication
private socket = io('http://localhost:6002/',{
    query: {token: environment.sampleToken }
  }).connect();
```

```
subscribing/listening to transaction changes
```
```typescript
constructor() {
    this.socket.on('connect', () => {
        console.log('CONNECTED');
    });
    this.socket.on('transaction_changes', (data: any) => {
        console.log('MESSAGE', data);
        
    });
    console.log(this.echo);
  }
```

```
broadcasting changes after saving transaction from other client
```
```typescript
  btnTransactionSave() {
    this.socket.emit('transaction_update', 
      {
        barangay_id: 1,
        transaction_id: 1
      }
    );
  }
```

```
whole code
```


```typescript
import { Component } from '@angular/core';
import { io } from 'socket.io-client';
import { environment } from 'src/environments/environment';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'websocket-sample';
  echo: any;
  private socket = io('http://localhost:6002/',{
    query: {token: environment.sampleToken }
  }).connect();
  
  constructor() {
    this.socket.on('connect', () => {
        console.log('CONNECTED');
    });
    this.socket.on('transaction_changes', (data: any) => {
        console.log('MESSAGE', data);
        
    });
    console.log(this.echo);
  }

  btnTransactionSave() {
    this.socket.emit('transaction_update', 
      {
        barangay_id: 1,
        transaction_id: 1
      }
    );
  }
}

```


```
app.component.html
```

```html
<button (click)="btnTransactionSave()">Press</button>
```