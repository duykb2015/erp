DROP DATABASE IF EXISTS erp;
CREATE DATABASE erp;
USE erp;

CREATE TABLE projects
(
  project_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  owner INT NOT NULL,
  PRIMARY KEY (project_id)
);

CREATE TABLE users
(
  user_id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NULL,
  firstname VARCHAR(255) NULL,
  lastname VARCHAR(255) NULL,
  type VARCHAR(255) NOT NULL,
  photo VARCHAR(255) NULL,
  PRIMARY KEY (user_id)
);

CREATE TABLE attachments
(
  attachment_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  type INT NOT NULL,
  PRIMARY KEY (attachment_id)
);

CREATE TABLE project_user
(
  id INT NOT NULL AUTO_INCREMENT,
  project_id INT NOT NULL,
  user_id INT NOT NULL,
  PRIMARY KEY (id, project_id, user_id),
  FOREIGN KEY (project_id) REFERENCES projects(project_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE tasks
(
  task_id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  descriptions TEXT NULL,
  priority INT NULL,
  status VARCHAR(255) NOT NULL,
  due_at DATETIME NULL,
  start_at DATETIME NULL,
  project_id INT NOT NULL,
  assignee INT NULL,
  PRIMARY KEY (task_id),
  FOREIGN KEY (project_id) REFERENCES projects(project_id),
  FOREIGN KEY (assignee) REFERENCES users(user_id)
);

CREATE TABLE comments
(
  comment_id INT NOT NULL AUTO_INCREMENT,
  text TEXT NOT NULL,
  type INT NOT NULL,
  task_id INT NOT NULL,
  created_by INT NOT NULL,
  PRIMARY KEY (comment_id),
  FOREIGN KEY (task_id) REFERENCES tasks(task_id),
  FOREIGN KEY (created_by) REFERENCES users(user_id)
);

CREATE TABLE attachment_comment
(
  id INT NOT NULL AUTO_INCREMENT,
  uploaded_by INT NOT NULL,
  comment_id INT NOT NULL,
  attachment_id INT NOT NULL,
  PRIMARY KEY (id, comment_id, attachment_id),
  FOREIGN KEY (comment_id) REFERENCES comments(comment_id),
  FOREIGN KEY (attachment_id) REFERENCES attachments(attachment_id)
);
