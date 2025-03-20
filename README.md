# Faithwork API Documentation

Welcome to the Faithwork API documentation. This API is designed for an e-commerce platform, providing endpoints for managing products, customers, orders, and authentication.

## Overview

- **API Version**: 1.0.0
- **Base URL**: `http://localhost:4000`

## Authentication

The API uses JWT Bearer authentication. Include the token in the `Authorization` header as follows:

```
Authorization: Bearer <token>
```

## Endpoints

### Health Check

- **GET** `/api/health`
  - **Summary**: Check the health of the service.
  - **Response**: `200 OK` - Service is running normally.

### Admin

- **GET** `/api/admin/migrations/up`
  - **Summary**: Execute migrations upwards.
  - **Responses**:
    - `204 No Content` - Migrations executed successfully.
    - `500 Internal Server Error` - Migration execution error.

- **GET** `/api/admin/migrations/down`
  - **Summary**: Rollback migrations.
  - **Responses**:
    - `204 No Content` - Migrations rolled back successfully.
    - `500 Internal Server Error` - Migration rollback error.

### Products

- **GET** `/api/product/products`
  - **Summary**: Retrieve all products.
  - **Response**: `200 OK` - List of products.

- **GET** `/api/product/products/{id}`
  - **Summary**: Retrieve a product by ID.
  - **Parameters**: `id` (integer, required)
  - **Responses**:
    - `200 OK` - Product data.
    - `404 Not Found` - Product not found.

### Customer

- **GET** `/api/customer/account/{id}`
  - **Summary**: Retrieve account data.
  - **Parameters**: `id` (integer, required)
  - **Responses**:
    - `200 OK` - Customer data.
    - `404 Not Found` - Customer not found.

- **PUT** `/api/customer/account/{id}`
  - **Summary**: Update account data.
  - **Parameters**: `id` (integer, required)
  - **Request Body**: `CustomerUpdate` schema
  - **Responses**:
    - `200 OK` - Data updated successfully.
    - `400 Bad Request` - Invalid data.

- **DELETE** `/api/customer/account/{id}`
  - **Summary**: Delete account.
  - **Parameters**: `id` (integer, required)
  - **Responses**:
    - `204 No Content` - Account deleted.
    - `404 Not Found` - Account not found.

### Authentication

- **POST** `/api/auth/login`
  - **Summary**: User authentication.
  - **Request Body**: `LoginRequest` schema
  - **Responses**:
    - `200 OK` - Successful authentication.
    - `401 Unauthorized` - Invalid credentials.

- **POST** `/api/auth/register`
  - **Summary**: Register a new user.
  - **Request Body**: `RegistrationRequest` schema
  - **Responses**:
    - `201 Created` - User created.
    - `400 Bad Request` - Invalid data.

- **POST** `/api/auth/logout`
  - **Summary**: Logout from account.
  - **Responses**:
    - `204 No Content` - Successful logout.
    - `401 Unauthorized` - Token not provided or invalid.

- **POST** `/api/auth/refresh`
  - **Summary**: Refresh token.
  - **Request Body**: `RefreshRequest` schema
  - **Responses**:
    - `200 OK` - Successful refresh.
    - `400 Bad Request` - Invalid refreshToken.

- **GET** `/api/auth/activate/{code}`
  - **Summary**: Activate account.
  - **Parameters**: `code` (string, required)
  - **Responses**:
    - `200 OK` - Account activated.
    - `400 Bad Request` - Invalid activation code.

### Orders

- **GET** `/api/order/orders`
  - **Summary**: Retrieve list of orders.
  - **Responses**: `200 OK` - List of orders.

- **POST** `/api/order/orders`
  - **Summary**: Create a new order.
  - **Request Body**: `OrderCreate` schema
  - **Responses**:
    - `201 Created` - Order created successfully.
    - `400 Bad Request` - Invalid order data.

- **PUT** `/api/order/orders/{id}`
  - **Summary**: Update order.
  - **Parameters**: `id` (integer, required)
  - **Request Body**: `OrderUpdate` schema
  - **Responses**:
    - `200 OK` - Order updated.
    - `400 Bad Request` - Invalid data.
    - `404 Not Found` - Order not found.

- **GET** `/api/order/orders/{id}`
  - **Summary**: Retrieve order by ID.
  - **Parameters**: `id` (integer, required)
  - **Responses**:
    - `200 OK` - Order data.
    - `404 Not Found` - Order not found.

- **DELETE** `/api/order/orders/{id}`
  - **Summary**: Delete order.
  - **Parameters**: `id` (integer, required)
  - **Responses**:
    - `204 No Content` - Order deleted.
    - `404 Not Found` - Order not found.

## Schemas

### Product

- **Properties**:
  - `id` (integer)
  - `quantity` (integer)
  - `price` (string)
  - `sizeId` (integer)

### Customer

- **Properties**:
  - `id` (integer)
  - `name` (string)
  - `email` (string, email format)
  - `phone` (string)

### CustomerUpdate

- **Properties**:
  - `name` (string)
  - `phone` (string)

### LoginRequest

- **Properties**:
  - `email` (string, email format)
  - `password` (string)
- **Required**: `email`, `password`

### AuthResponse

- **Properties**:
  - `token` (string)
  - `refreshToken` (string)

### Order

- **Properties**:
  - `id` (integer)
  - `customerId` (integer)
  - `status` (integer)
  - `paymentStatus` (integer)
  - `items` (array of `Product`)
  - `totalPrice` (string)

### OrderCreate

- **Properties**:
  - `items` (array of `Product`)
- **Required**: `items`

### RegistrationRequest

- **Properties**:
  - `email` (string, email format)
  - `password` (string)
- **Required**: `email`, `password`

### OrderUpdate

- **Properties**:
  - `id` (integer)
  - `status` (integer)
  - `paymentStatus` (integer)
  - `items` (array of `Product`)
  - `totalPrice` (string)

### RefreshRequest

- **Properties**:
  - `refreshToken` (string)
- **Required**: `refreshToken`

## Security Schemes

- **BearerAuth**: HTTP Bearer authentication using JWT.

