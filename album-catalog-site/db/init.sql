CREATE TABLE albums (
    id INTEGER NOT NULL UNIQUE,
    title TEXT NOT NULL,
    artist TEXT NOT NULL,
    user TEXT NOT NULL,
    file_name TEXT NOT NULL,
    file_ext TEXT NOT NULL,
    source TEXT,
    PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        1,
        'Immunity',
        'Clairo',
        'Courtney Swan',
        '1.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://en.wikipedia.org/wiki/Immunity_(Clairo_album)'
    );

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        2,
        'SOS',
        'SZA',
        'Courtney Swan',
        '2.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://en.wikipedia.org/wiki/SOS_(SZA_album)'
    );

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        3,
        'Igor',
        'Tyler the Creator',
        'Emily Hansen',
        '3.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://en.wikipedia.org/wiki/Flower_Boy'
    );

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        4,
        'Beatopia',
        'beabadoobee',
        'Emily Hansen',
        '4.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://en.wikipedia.org/wiki/Beatopia'
    );

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        5,
        'Saw you in a Dream',
        'Japanese House',
        'Lindsay Blocker',
        '5.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://dayglowband.bandcamp.com/album/fuzzybrain'
    );

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        6,
        'The Star Chapter: Sanctuary',
        'TXT',
        'Lindsay Blocker',
        '6.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://en.wikipedia.org/wiki/Nothing_Happens_(album)'
    );

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        7,
        'summer flows 0.02',
        'Wave to Earth',
        'Anna Shang',
        '7.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://pitchfork.com/reviews/albums/clairo-diary-001-ep/'
    );

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        8,
        'Sector 17',
        'Seventeen',
        'Anna Shang',
        '8.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://en.wikipedia.org/wiki/Love_Yourself:_Answer'
    );

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        9,
        'Short n'' Sweet',
        'Sabrina Carpentar',
        'Emily Hansen',
        '9.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://en.wikipedia.org/wiki/Be_the_Cowboy'
    );

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        10,
        'Blonde',
        'Frank Ocean',
        'Courtney Swan',
        '10.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://en.wikipedia.org/wiki/Ballads_1'
    );

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        11,
        'Cosmic',
        'Red Velvet',
        'Anna Shang',
        '11.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://en.wikipedia.org/wiki/Maxident'
    );

INSERT INTO
    albums (
        id,
        title,
        artist,
        user,
        file_name,
        file_ext,
        source
    )
VALUES
    (
        12,
        'Eternal Sunshine',
        'Ariana Grande',
        'Lindsay Blocker',
        '12.jpg',
        'jpg',
        -- Source: (Original Work) Anna Shang
        -- Outer frame: Canva
        'https://en.wikipedia.org/wiki/Bury_Me_at_Makeout_Creek'
    );

CREATE TABLE genres (
    id INTEGER NOT NULL UNIQUE,
    genre TEXT NOT NULL,
    PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
    genres (id, genre)
VALUES
    (1, 'Pop');

INSERT INTO
    genres (id, genre)
VALUES
    (2, 'Alternative/Indie');

INSERT INTO
    genres (id, genre)
VALUES
    (3, 'R&B');

INSERT INTO
    genres (id, genre)
VALUES
    (4, 'Hip-Hop/Rap');

INSERT INTO
    genres (id, genre)
VALUES
    (5, 'K-Pop');

CREATE TABLE album_genres (
    id INTEGER NOT NULL UNIQUE,
    album_id INTEGER NOT NULL,
    genre_id INTEGER NOT NULL,
    PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (1, 1, 1);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (2, 1, 2);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (3, 2, 3);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (4, 3, 4);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (5, 4, 2);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (6, 5, 1);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (7, 5, 2);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (8, 6, 5);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (9, 7, 2);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (10, 7, 5);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (11, 8, 4);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (12, 8, 5);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (13, 9, 1);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (14, 10, 3);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (15, 10, 4);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (16, 11, 1);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (17, 11, 5);

INSERT INTO
    album_genres (id, album_id, genre_id)
VALUES
    (18, 12, 1);

--- Users ---
CREATE TABLE users (
    id INTEGER NOT NULL UNIQUE,
    name TEXT NOT NULL,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
    users (id, name, username, password)
VALUES
    (
        1,
        'Courtney Swan',
        'courtney',
        '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
    );

INSERT INTO
    users (id, name, username, password)
VALUES
    (
        2,
        'Emily Hansen',
        'emily',
        '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
    );

INSERT INTO
    users (id, name, username, password)
VALUES
    (
        3,
        'Lindsay Blocker',
        'lindsay',
        '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
    );

INSERT INTO
    users (id, name, username, password)
VALUES
    (
        4,
        'Anna Shang',
        'anna',
        '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
    );

CREATE TABLE sessions (
    id INTEGER NOT NULL UNIQUE,
    user_id INTEGER NOT NULL,
    session TEXT NOT NULL UNIQUE,
    last_login TEXT NOT NULL,
    PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE groups (
    id INTEGER NOT NULL UNIQUE,
    name TEXT NOT NULL UNIQUE,
    PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
    groups (id, name)
VALUES
    (1, 'admin');

--- Group Membership ---
CREATE TABLE user_groups (
    id INTEGER NOT NULL UNIQUE,
    user_id INTEGER NOT NULL,
    group_id INTEGER NOT NULL,
    PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY(group_id) REFERENCES groups(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

INSERT INTO
    user_groups (user_id, group_id)
VALUES
    (1, 1);

INSERT INTO
    user_groups (user_id, group_id)
VALUES
    (2, 1);

INSERT INTO
    user_groups (user_id, group_id)
VALUES
    (3, 1);

INSERT INTO
    user_groups (user_id, group_id)
VALUES
    (4, 1);
