CREATE TABLE IF NOT EXISTS registrations (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  gender VARCHAR(10) NOT NULL,
  course_id INT NOT NULL,
  agree_terms TINYINT(1) NOT NULL DEFAULT 0,
  ip_address VARCHAR(50),
  browser_info VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (course_id) REFERENCES courses(id)
);
