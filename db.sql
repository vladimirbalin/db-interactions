CREATE TABLE posts
(
    id    INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body  TEXT         NOT NULL
);
CREATE TABLE comments
(
    id      INT PRIMARY KEY,
    post_id INT,
    body    TEXT NOT NULL,
    CONSTRAINT FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE
);