-- =============================================================================
-- Journey Masters Ltd — MySQL schema
-- PHP 8 / PDO / MySQL 8 (or MariaDB 10.4+). Charset utf8mb4.
-- Import via cPanel > phpMyAdmin, then set DB_ENABLED=true in .env.
-- =============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------- Auth / RBAC
CREATE TABLE IF NOT EXISTS roles (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(50) NOT NULL UNIQUE,
    label       VARCHAR(100) NOT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS permissions (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(80) NOT NULL UNIQUE,
    label       VARCHAR(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS role_permission (
    role_id       INT UNSIGNED NOT NULL,
    permission_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id)       REFERENCES roles(id)       ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS users (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_id      INT UNSIGNED NULL,
    name         VARCHAR(120) NOT NULL,
    email        VARCHAR(180) NOT NULL UNIQUE,
    password     VARCHAR(255) NOT NULL,
    avatar       VARCHAR(255) NULL,
    is_active    TINYINT(1) NOT NULL DEFAULT 1,
    last_login   DATETIME NULL,
    remember_token VARCHAR(100) NULL,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL,
    INDEX idx_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------- Content
CREATE TABLE IF NOT EXISTS services (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug         VARCHAR(150) NOT NULL UNIQUE,
    title        VARCHAR(160) NOT NULL,
    tagline      VARCHAR(255) NULL,
    summary      TEXT NULL,
    overview     MEDIUMTEXT NULL,
    icon         TEXT NULL,
    image        VARCHAR(255) NULL,
    sort_order   INT NOT NULL DEFAULT 0,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_services_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS service_features (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    service_id  INT UNSIGNED NOT NULL,
    type        ENUM('benefit','requirement','timeline','faq') NOT NULL,
    title       VARCHAR(200) NULL,
    body        TEXT NULL,
    sort_order  INT NOT NULL DEFAULT 0,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    INDEX idx_feature_service (service_id, type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS destinations (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug         VARCHAR(150) NOT NULL UNIQUE,
    country      VARCHAR(120) NOT NULL,
    title        VARCHAR(200) NOT NULL,
    intro        TEXT NULL,
    duration     VARCHAR(120) NULL,
    image        VARCHAR(255) NULL,
    highlights   TEXT NULL,
    requirements TEXT NULL,
    sort_order   INT NOT NULL DEFAULT 0,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS galleries (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    destination_id INT UNSIGNED NULL,
    image          VARCHAR(255) NOT NULL,
    caption        VARCHAR(200) NULL,
    sort_order     INT NOT NULL DEFAULT 0,
    FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS post_categories (
    id    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug  VARCHAR(120) NOT NULL UNIQUE,
    name  VARCHAR(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS posts (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id  INT UNSIGNED NULL,
    author_id    INT UNSIGNED NULL,
    slug         VARCHAR(180) NOT NULL UNIQUE,
    title        VARCHAR(220) NOT NULL,
    excerpt      TEXT NULL,
    body         MEDIUMTEXT NULL,
    image        VARCHAR(255) NULL,
    read_time    VARCHAR(20) NULL,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    published_at DATETIME NULL,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES post_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id)   REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_posts_slug (slug),
    INDEX idx_posts_published (is_published, published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS testimonials (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(120) NOT NULL,
    role        VARCHAR(160) NULL,
    avatar      VARCHAR(255) NULL,
    quote       TEXT NOT NULL,
    rating      TINYINT NOT NULL DEFAULT 5,
    sort_order  INT NOT NULL DEFAULT 0,
    is_published TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS faqs (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question    VARCHAR(255) NOT NULL,
    answer      TEXT NOT NULL,
    sort_order  INT NOT NULL DEFAULT 0,
    is_published TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS team_members (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(120) NOT NULL,
    role        VARCHAR(160) NULL,
    photo       VARCHAR(255) NULL,
    bio         TEXT NULL,
    sort_order  INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------- Site config
CREATE TABLE IF NOT EXISTS settings (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key`       VARCHAR(120) NOT NULL UNIQUE,
    value       TEXT NULL,
    `group`     VARCHAR(60) NOT NULL DEFAULT 'general'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS social_links (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    platform    VARCHAR(60) NOT NULL,
    url         VARCHAR(255) NOT NULL,
    icon        VARCHAR(60) NULL,
    sort_order  INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS seo_meta (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    route           VARCHAR(180) NOT NULL UNIQUE,
    meta_title      VARCHAR(200) NULL,
    meta_description VARCHAR(300) NULL,
    og_image        VARCHAR(255) NULL,
    canonical       VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS media (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    filename    VARCHAR(255) NOT NULL,
    path        VARCHAR(255) NOT NULL,
    mime        VARCHAR(100) NULL,
    size        INT UNSIGNED NULL,
    alt         VARCHAR(200) NULL,
    uploaded_by INT UNSIGNED NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------- Leads / logs
CREATE TABLE IF NOT EXISTS messages (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(120) NOT NULL,
    email       VARCHAR(180) NOT NULL,
    phone       VARCHAR(40) NULL,
    service     VARCHAR(160) NULL,
    message     TEXT NOT NULL,
    ip_address  VARCHAR(45) NULL,
    is_read     TINYINT(1) NOT NULL DEFAULT 0,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_messages_read (is_read, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS subscribers (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email       VARCHAR(180) NOT NULL UNIQUE,
    ip_address  VARCHAR(45) NULL,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS audit_logs (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NULL,
    action      VARCHAR(120) NOT NULL,
    entity      VARCHAR(120) NULL,
    entity_id   INT UNSIGNED NULL,
    ip_address  VARCHAR(45) NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_audit_user (user_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------- Seed: RBAC
INSERT INTO roles (name, label) VALUES
    ('super_admin', 'Super Admin'),
    ('admin', 'Administrator'),
    ('editor', 'Content Editor')
ON DUPLICATE KEY UPDATE label = VALUES(label);

-- Default admin — CHANGE THIS PASSWORD immediately after first login.
-- Hash below is password_hash('ChangeMe!2025', PASSWORD_DEFAULT).
INSERT INTO users (role_id, name, email, password)
SELECT r.id, 'Site Administrator', 'admin@journeymastersltd.com',
       '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HlUq9x1p1x4kQG5uJ5s6hQnJ5w3Q0G'
FROM roles r WHERE r.name = 'super_admin'
ON DUPLICATE KEY UPDATE email = email;

SET FOREIGN_KEY_CHECKS = 1;
