CREATE TABLE users
(
    user_id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(25) NOT NULL UNIQUE,
    password CHAR(161) NOT NULL
);

CREATE TABLE notifications
(
    notification_id BIGSERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users,
    notification_date TIMESTAMP,
    notification_text TEXT
);

CREATE TABLE modules
(
    module_id SERIAL PRIMARY KEY,
    module_name VARCHAR(100)
);

CREATE TABLE lessons
(
    lesson_id SERIAL PRIMARY KEY,
    module_id INTEGER REFERENCES modules,
    lesson_name VARCHAR(100)
);

CREATE TABLE teams
(
    team_id SERIAL PRIMARY KEY,
    team_name VARCHAR(100)
);

CREATE TABLE user_teams
(
    user_team_id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users,
    team_id INTEGER REFERENCES teams
);

CREATE TABLE news
(
    news_id SERIAL PRIMARY KEY,
    news_text TEXT,
    news_source VARCHAR(255),
    news_date TIMESTAMP
);

CREATE TABLE rewards
(
    reward_id SERIAL PRIMARY KEY,
    reward_points INTEGER
);

CREATE TABLE challenges
(
    challenge_id SERIAL PRIMARY KEY,
    lesson_id INTEGER REFERENCES lessons,
    reward_id INTEGER REFERENCES rewards
);

CREATE TABLE user_progress
(
    progress_id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users,
    challenge_id INTEGER REFERENCES challenges,
    is_completed BOOLEAN,
    completion_date TIMESTAMP
);

CREATE TABLE leaderboard
(
    user_id INTEGER PRIMARY KEY REFERENCES users,
    points_challenges INTEGER DEFAULT 0
);

INSERT INTO modules (module_id, module_name) VALUES (1, 'ATTACK'), (2, 'GENERAL'), (3, 'DEFENCE');
INSERT INTO lessons (lesson_id, module_id, lesson_name) VALUES (1, 1, 'SQL Injection'), (2, 1, 'Cross-Site Scripting (XSS)'), (3, 1, 'File Inclusion');
INSERT INTO rewards (reward_id, reward_points) VALUES (1, 100), (2, 200), (3, 300), (4, 400), (5, 500);
INSERT INTO challenges (challenge_id, lesson_id, reward_id) VALUES (7, 3, 1), (2, 1, 2), (5, 2, 2), (8, 3, 2), (1, 1, 1), (9, 3, 3), (3, 1, 3), (6, 2, 3), (4, 2, 1);
INSERT INTO users (email, username, password) VALUES ('admin', 'admin', 'admin'), ('admin2', 'admin2', 'admin2');
INSERT INTO leaderboard (user_id, points_challenges) VALUES (1, 100), (2, 200);
INSERT INTO notifications (notification_id, user_id, notification_date, notification_text) VALUES (1, 1, '2023-11-09 11:21:01', NULL), (2, 2, '2023-11-09 11:26:00', NULL), (3, 2, '2023-11-09 11:26:02', NULL);
INSERT INTO teams (team_id, team_name) VALUES (1, 'h4ck3r5'), (2, 'h4ck3rm3n');
INSERT INTO user_progress (progress_id, user_id, challenge_id, is_completed, completion_date) VALUES (2, 1, 1, FALSE, NULL), (3, 1, 2, FALSE, NULL), (4, 1, 3, FALSE, NULL), (5, 2, 1, FALSE, NULL), (6, 2, 2, FALSE, NULL), (7, 2, 3, FALSE, NULL);
INSERT INTO user_teams (user_team_id, user_id, team_id) VALUES (1, 1, 1), (2, 1, 2), (3, 2, 1);
