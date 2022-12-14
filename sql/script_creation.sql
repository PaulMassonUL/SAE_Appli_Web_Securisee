-- Adminer 4.8.1 MySQL 5.5.5-10.3.11-MariaDB-1:10.3.11+maria~bionic dump

SET NAMES utf8;
SET
    time_zone = '+00:00';
SET
    foreign_key_checks = 0;
SET
    sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `users`;
CREATE TABLE users
(
    email              varchar(75) NOT NULL,
    password           LONGTEXT    NOT NULL,
    nom                VARCHAR(128),
    prenom             VARCHAR(128),
    age                int,
    genrePref          VARCHAR(128),
    active             int(1) DEFAULT 0,
    activation_token   varchar(128),
    activation_expires DATETIME,
    renew_token        varchar(128),
    renew_expires      DATETIME,
    PRIMARY KEY (email)
);

DROP TABLE IF EXISTS `Notation`;
CREATE TABLE Notation
(
    idSerie int(11)     NOT NULL,
    email   varchar(75) NOT NULL,
    note    int(1),
    PRIMARY KEY (idSerie, email)
);

DROP TABLE IF EXISTS `Commentaire`;
CREATE TABLE Commentaire
(
    idSerie     int(11)     NOT NULL,
    email       varchar(75) NOT NULL,
    commentaire LONGTEXT,
    PRIMARY KEY (idSerie, email)
);

DROP TABLE IF EXISTS `seriePreferee`;
CREATE TABLE seriePreferee
(
    idSerie int(11)     NOT NULL,
    email   varchar(75) NOT NULL,
    PRIMARY KEY (idSerie, email)
);

DROP TABLE IF EXISTS `episodeVisionne`;
CREATE TABLE episodeVisionne
(
    idEpisode int(11)     NOT NULL,
    email     varchar(75) NOT NULL,
    PRIMARY KEY (idEpisode, email)
);

DROP TABLE IF EXISTS `serie`;
CREATE TABLE `serie`
(
    `id`         int(11)      NOT NULL AUTO_INCREMENT,
    `titre`      varchar(128) NOT NULL,
    `descriptif` text         NOT NULL,
    `img`        varchar(256) NOT NULL,
    `annee`      int(11)      NOT NULL,
    `date_ajout` date         NOT NULL,
    `genre`      varchar(128) NOT NULL,
    `public`     varchar(128) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `episode`;
CREATE TABLE `episode`
(
    `id`       int(11)      NOT NULL AUTO_INCREMENT,
    `numero`   int(11)      NOT NULL DEFAULT 1,
    `titre`    varchar(128) NOT NULL,
    `resume`   text                  DEFAULT NULL,
    `duree`    int(11)      NOT NULL DEFAULT 0,
    `file`     varchar(256)          DEFAULT NULL,
    `serie_id` int(11)               DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO `episode` (`id`, `numero`, `titre`, `resume`, `duree`, `file`, `serie_id`)
VALUES (1, 1, 'Le lac', 'Le lac se r??volte ', 8, 'lake.mp4', 1),
       (2, 2, 'Le lac : les myst??res de l\'eau trouble',
        'Un grand myst??re, l\'eau du lac est trouble. Jack trouvera-t-il la solution ?', 8, 'lake.mp4', 1),
       (3, 3, 'Le lac : les myst??res de l\'eau sale',
        'Un grand myst??re, l\'eau du lac est sale. Jack trouvera-t-il la solution ?', 8, 'lake.mp4', 1),
       (4, 3, 'Le lac : les myst??res de l\'eau chaude',
        'Un grand myst??re, l\'eau du lac est chaude. Jack trouvera-t-il la solution ?', 8, 'lake.mp4', 1),
       (5, 3, 'Le lac : les myst??res de l\'eau froide',
        'Un grand myst??re, l\'eau du lac est froide. Jack trouvera-t-il la solution ?', 8, 'lake.mp4', 1),
       (6, 1, 'Eau calme', 'L\'eau coule tranquillement au fil du temps.', 15, 'water.mp4', 2),
       (7, 2, 'Eau calme 2', 'Le temps a pass??, l\'eau coule toujours tranquillement.', 15, 'water.mp4', 2),
       (8, 3, 'Eau moins calme', 'Le temps des tourments est pour bient??t, l\'eau s\'agite et le temps passe.', 15,
        'water.mp4', 2),
       (9, 4, 'la temp??te',
        'C\'est la temp??te, l\'eau est en pleine agitation. Le temps passe mais rien n\' y fait.Jack trouvera - t - il
        la solution ? ',
        15, ' water.mp4 ', 2),
       (10, 5, ' Le calme apr??s la temp??te ',
        ' La temp??te est pass??e, l\'eau retrouve son calme. Le temps passe et Jack part en vacances.', 15, 'water.mp4',
        2),
       (11, 1, 'les chevaux s\'amusent',
        'Les chevaux s\'amusent bien, ils ont apport??s les raquettes pour faire un tournoi de badmington.', 7,
        'horses.mp4', 3),
       (12, 2, 'les chevals fous',
        '- Oh regarde, des beaux chevals !!\r\n- non, des chevaux, des CHEVAUX !\r\n- oh, bin ??a alors, ??a ressemble dr??lement ?? des chevals ?!!?',
        7, 'horses.mp4', 3),
       (13, 3, 'les chevaux de l\'??toile noire',
        'Les chevaux de l\'Etoile Noire d??brquent sur terre et mangent toute l\'herbe !', 7, 'horses.mp4', 3),
       (14, 1, 'Tous ?? la plage', 'C\'est l\'??t??, tous ?? la plage pour profiter du soleil et de la mer.', 18,
        'beach.mp4', 4),
       (15, 2, 'La plage le soir', 'A la plage le soir, il n\'y a personne, c\'est tout calme', 18, 'beach.mp4', 4),
       (16, 3, 'La plage le matin',
        'A la plage le matin, il n\'y a personne non plus, c\'est tout calme et le jour se l??ve.', 18, 'beach.mp4', 4),
       (17, 1, 'champion de surf', 'Jack fait du surf le matin, le midi le soir, m??me la nuit. C\'est un pro.', 11,
        'surf.mp4', 5),
       (18, 2, 'surf d??tective',
        'Une planche de surf a ??t?? vol??e. Jack m??ne l\'enqu??te. Parviendra-t-il ?? confondre le brigand ?', 11,
        'surf.mp4', 5),
       (19, 3, 'surf amiti??',
        'En fait la planche n\'avait pas ??t?? vol??e, c\'est Jim, le meilleur ami de Jack,
        qui lui avait fait une blague. Les deux amis partagent une menthe ?? l\'eau pour c??l??brer leur amiti?? sans faille.',
        11, 'surf.mp4', 5),
       (20, 1, '??a roule, ??a roule',
        '??a roule, ??a roule toute la nuit. Jack fonce dans sa camionnette pour rejoindre le spot de surf.', 27,
        'cars-by-night.mp4', 6),
       (21, 2, '??a roule, ??a roule toujours',
        '??a roule la nuit, comme chaque nuit. Jim fonce avec son taxi, pour rejoindre Jack ?? la plage. De l\'eau a coul?? sous les ponts. Le myst??re du Lac trouve sa solution alors que les chevaux sont de retour apr??s une vir??e sur l\'Etoile Noire.',
        27, 'cars-by-night.mp4', 6);



INSERT INTO `serie` (`id`, `titre`, `descriptif`, `img`, `annee`, `date_ajout`, `genre`, `public`)
VALUES (1, 'Le lac aux myst??res',
        'C\'est l\'histoire d\'un lac myst??rieux et plein de surprises. La s??rie, bluffante et haletante,
        nous entraine dans un labyrinthe d\'intrigues ??poustouflantes. A ne rater sous aucun pr??texte !',
        'lac_aux_mysteres.jpg', 2020, '2022-10-30', 'Fantaisie', 'Tout public'),
       (2, 'L\'eau a coul??',
        'Une s??rie nostalgique qui nous invite ?? revisiter notre pass?? et ?? se rem??morer tout ce qui s\'est pass?? depuis que tant d\'eau a coul?? sous les ponts.',
        'eau_a_coule.jpg', 1907, '2022-10-29', 'Histoire', 'Tout public'),
       (3, 'Chevaux fous', 'Une s??rie sur la vie des chevals sauvages en libert??. D??coiffante.', 'chevaux_fous.jpg',
        2017,
        '2022-10-31', 'Documentaire', 'Tout public'),
       (4, 'A la plage', 'Le succ??s de l\'??t?? 2021, ?? regarder sans mod??ration et entre amis.', 'a_la_plage.jpg', 2021,
        '2022-11-04', 'Com??die', 'Adultes'),
       (5, 'Champion',
        'La vie tr??pidante de deux champions de surf, passionn??s d??s leur plus jeune age. Ils consacrent leur vie ?? ce sport. ',
        'champion.jpg', 2022, '2022-11-03', 'Sport', 'Tout public'),
       (6, 'Une ville la nuit',
        'C\'est beau une ville la nuit, avec toutes ces voitures qui passent et qui repassent. La s??rie suit un livreur,
        un chauffeur de taxi, et un insomniaque. Tous parcourent la grande ville une fois la nuit venue, au volant de leur v??hicule.',
        'une_ville_la_nuit.jpg', 2017, '2022-10-31', 'Documentaire', 'Tout public');

-- 2022-10-31 16:33:40



