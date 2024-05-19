-- Create database
CREATE DATABASE flixpicks_database;

-- Use database
USE flixpicks_database;

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insert user records
INSERT INTO users (name, email, password) VALUES
('Jieya Zhou', '20754017@student.westernsydney.edu.au', 'password123'),
('Munjerin Hossain', '22056673@student.westernsydney.edu.au', 'password456');

-- Create movie table
CREATE TABLE movie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    director VARCHAR(255) NOT NULL,
    release_year YEAR NOT NULL,
    synopsis TEXT,
    poster_url VARCHAR(255)
);

-- Insert movie records
INSERT INTO movie (name, director, release_year, synopsis, poster_url) VALUES
('Inception', 'Christopher Nolan', 2010, 'A thief who steals corporate secrets through the use of dream-sharing technology.', 'https://image.tmdb.org/t/p/original/edv5CZvWj09upOsy2Y6IwDhK8bt.jpg'),
('The Matrix', 'Lana Wachowski, Lilly Wachowski', 1999, 'A computer hacker learns about the true nature of his reality and his role in the war against its controllers.', 'https://image.tmdb.org/t/p/original/sRaupdJawe6UTS0t77vwJoLjd7h.jpg'),
('Interstellar', 'Christopher Nolan', 2014, 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.', 'https://posterspy.com/wp-content/uploads/2022/08/Interstellar_poster.jpg'),
('Parasite', 'Bong Joon Ho', 2019, 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.', 'https://image.tmdb.org/t/p/original/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg'),
('The Godfather', 'Francis Ford Coppola', 1972, 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', 'https://image.tmdb.org/t/p/original/3bhkrj58Vtu7enYsRolD1fZdja1.jpg'),
('Pulp Fiction', 'Quentin Tarantino', 1994, 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption.', 'https://image.tmdb.org/t/p/original/wZbnRMarWnO4DJRisOaK4QEg1tl.jpg');


-- Create rating table
CREATE TABLE rating (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    movie_id INT,
    review_comment TEXT,
    star_rating INT,
    FOREIGN KEY (user_id) REFERENCES users(id), -- only user can rating
    FOREIGN KEY (movie_id) REFERENCES movie(id)
);


-- Insert rating records
INSERT INTO rating (user_id, movie_id, review_comment, star_rating) VALUES
(1, 1, 'Amazing plot and visuals. A masterpiece.', 5),  -- User ID 1 posted a review
(1, 1, 'Mind-bending and thrilling from start to finish.', 5),
(2, 2, 'A groundbreaking sci-fi movie that still holds up.', 5),  -- User ID 2 posted a review
(2, 2, 'Revolutionary action scenes and a deep storyline.', 4),
(1, 3, 'A visually stunning and thought-provoking film.', 5),  -- User ID 1 posted a review
(1, 3, 'Nolan\'s best work to date. A must-watch.', 5),
(2, 4, 'An intense and gripping social commentary.', 5),  -- User ID 2 posted a review
(2, 4, 'A brilliantly crafted movie with superb acting.', 5),
(1, 5, 'A timeless classic. One of the greatest films ever made.', 5),  -- User ID 1 posted a review
(1, 5, 'Exceptional storytelling and performances.', 5),
(2, 6, 'Tarantino\'s masterpiece. An iconic film.', 5),  -- User ID 2 posted a review
(2, 6, 'A unique blend of humor and violence. Brilliant.', 4);


-- Create watchlist table
CREATE TABLE watchlist (
    user_id INT,
    movie_id INT,
    PRIMARY KEY (user_id, movie_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (movie_id) REFERENCES movie(id)
);

-- Insert watchlist records for Jieya 
INSERT INTO watchlist (user_id, movie_id) VALUES
(1, 1),  -- Alice has Inception in her watchlist
(1, 3),  -- Alice has Interstellar in her watchlist
(1, 5);  -- Alice has The Godfather in her watchlist

-- Insert watchlist records for Munjerin
INSERT INTO watchlist (user_id, movie_id) VALUES
(2, 2),  -- Bob has The Matrix in his watchlist
(2, 4),  -- Bob has Parasite in his watchlist
(2, 6);  -- Bob has Pulp Fiction in his watchlist

-- Create discussion table
CREATE TABLE discussion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT,
    user_id INT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movie(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
