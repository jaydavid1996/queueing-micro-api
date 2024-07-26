# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/lumen)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

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