-- Database schema for Anvaya project

CREATE TABLE users (
    user_id         INT AUTO_INCREMENT PRIMARY KEY,
    first_name      VARCHAR(50),
    last_name       VARCHAR(50),
    email           VARCHAR(100) UNIQUE NOT NULL,
    phone           VARCHAR(20) UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_design_preferences (
    preference_id   INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT,
    -- gender          VARCHAR(20),
    occasion        VARCHAR(50),
    style           VARCHAR(100),
    budget          DECIMAL(10,2),
    liked_items     TEXT,
    age             INT,
    height          VARCHAR(20),
    approx_size     VARCHAR(20),
    colour          VARCHAR(50),
    uploaded_photo  VARCHAR(255),
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE designers (
    designer_id     INT AUTO_INCREMENT PRIMARY KEY,
    designer_name   VARCHAR(100),
    username        VARCHAR(50) UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    phone           VARCHAR(20),
    email           VARCHAR(100) UNIQUE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    order_id        INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT,
    preference_id   INT,
    designer_id     INT NULL,
    delivery_address TEXT,
    status ENUM(
        'order_received',
        'order_confirm',
        'in_process',
        'out_for_delivery',
        'delivered',
        'approve',
        'reject'
    ) DEFAULT 'order_received',
    final_style_desc TEXT,
    measurement     TEXT,
    final_price     DECIMAL(10,2),
    delivery_date   DATE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (preference_id) REFERENCES user_design_preferences(preference_id),
    FOREIGN KEY (designer_id) REFERENCES designers(designer_id)
);

CREATE TABLE order_status_history (
    status_id       INT AUTO_INCREMENT PRIMARY KEY,
    order_id        INT,
    status          ENUM(
        'order_received',
        'order_confirm',
        'in_process',
        'out_for_delivery',
        'delivered',
        'approve',
        'reject'
    ),
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by      VARCHAR(50),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
);

CREATE TABLE contact_requests (
    request_id      INT AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100),
    email           VARCHAR(100),
    phone           VARCHAR(20),
    subject         VARCHAR(200),
    message         TEXT,
    date_submitted  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status          ENUM('pending','read') DEFAULT 'pending',
    action_taken    TEXT
);

CREATE TABLE admins (
    admin_id        INT AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(50) UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    email           VARCHAR(100),
    phone           VARCHAR(20),
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Reviews table with order_id and all required columns
CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    review_text TEXT,
    photo VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
