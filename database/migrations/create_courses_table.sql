CREATE TABLE IF NOT EXISTS courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_name VARCHAR(100) NOT NULL
);

INSERT INTO courses (course_name) VALUES 
('Web Development'),
('Data Science'),
('Mobile Apps'),
('UI/UX Design');
