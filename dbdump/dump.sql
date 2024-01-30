--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1 (Debian 16.1-1.pgdg120+1)
-- Dumped by pg_dump version 16.0

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: add_to_leaderboard(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.add_to_leaderboard(user_id_arg integer, points_challenges_arg integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO leaderboard (user_id, points_challenges) VALUES (user_id_arg, points_challenges_arg);
END;
$$;


ALTER FUNCTION public.add_to_leaderboard(user_id_arg integer, points_challenges_arg integer) OWNER TO postgres;

--
-- Name: add_welcome_notification(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.add_welcome_notification() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO notifications (user_id, notification_date, notification_text)
    VALUES (NEW.user_id, CURRENT_TIMESTAMP, 'Welcome to the HackTheRoot, good luck!');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.add_welcome_notification() OWNER TO postgres;

--
-- Name: clear_all_tables(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.clear_all_tables() RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    TRUNCATE TABLE modules CASCADE;
    TRUNCATE TABLE lessons CASCADE;
    TRUNCATE TABLE news CASCADE;
    TRUNCATE TABLE rewards CASCADE;
    TRUNCATE TABLE challenges CASCADE;
    TRUNCATE TABLE users CASCADE;
    TRUNCATE TABLE leaderboard CASCADE;
    TRUNCATE TABLE notifications CASCADE;
    TRUNCATE TABLE user_progress CASCADE;
    TRUNCATE TABLE tips_of_the_day CASCADE;
END;
$$;


ALTER FUNCTION public.clear_all_tables() OWNER TO postgres;

--
-- Name: clear_few_tables(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.clear_few_tables() RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    TRUNCATE TABLE users CASCADE;
    TRUNCATE TABLE leaderboard CASCADE;
    TRUNCATE TABLE news CASCADE;
    TRUNCATE TABLE notifications CASCADE;
END;
$$;


ALTER FUNCTION public.clear_few_tables() OWNER TO postgres;

--
-- Name: update_leaderboard_points(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_leaderboard_points() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM leaderboard WHERE user_id = NEW.user_id) THEN
        UPDATE leaderboard
        SET points_challenges = points_challenges +
                                (SELECT reward_points FROM rewards WHERE reward_id =
                                                                         (SELECT reward_id FROM challenges WHERE challenge_id = NEW.challenge_id))
        WHERE user_id = NEW.user_id;
    ELSE
        INSERT INTO leaderboard (user_id, points_challenges)
        VALUES (NEW.user_id,
                (SELECT reward_points FROM rewards WHERE reward_id =
                                                         (SELECT reward_id FROM challenges WHERE challenge_id = NEW.challenge_id)));
    END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_leaderboard_points() OWNER TO postgres;

--
-- Name: update_user_progress(integer, integer, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_user_progress(user_id_arg integer, challenge_id_arg integer, is_correct_arg boolean) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
    existing_record record;
BEGIN
    SELECT * INTO existing_record FROM user_progress WHERE user_id = user_id_arg AND challenge_id = challenge_id_arg;

    IF existing_record IS NULL THEN
        INSERT INTO user_progress (user_id, challenge_id, is_completed, completion_date)
        VALUES (user_id_arg, challenge_id_arg, is_correct_arg, CURRENT_TIMESTAMP);
    ELSIF NOT existing_record.is_completed AND is_correct_arg THEN
        UPDATE user_progress SET is_completed = true, completion_date = CURRENT_TIMESTAMP
        WHERE user_id = user_id_arg AND challenge_id = challenge_id_arg;
    END IF;
END;
$$;


ALTER FUNCTION public.update_user_progress(user_id_arg integer, challenge_id_arg integer, is_correct_arg boolean) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: challenges; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.challenges (
    challenge_id integer NOT NULL,
    lesson_id integer,
    reward_id integer,
    challenge_text text,
    challenge_answer text
);


ALTER TABLE public.challenges OWNER TO postgres;

--
-- Name: challenges_challenge_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.challenges_challenge_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.challenges_challenge_id_seq OWNER TO postgres;

--
-- Name: challenges_challenge_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.challenges_challenge_id_seq OWNED BY public.challenges.challenge_id;


--
-- Name: leaderboard; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.leaderboard (
    user_id integer NOT NULL,
    points_challenges integer DEFAULT 0
);


ALTER TABLE public.leaderboard OWNER TO postgres;

--
-- Name: lessons; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.lessons (
    lesson_id integer NOT NULL,
    module_id integer,
    lesson_name character varying(100)
);


ALTER TABLE public.lessons OWNER TO postgres;

--
-- Name: lessons_lesson_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lessons_lesson_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lessons_lesson_id_seq OWNER TO postgres;

--
-- Name: lessons_lesson_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.lessons_lesson_id_seq OWNED BY public.lessons.lesson_id;


--
-- Name: modules; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.modules (
    module_id integer NOT NULL,
    module_name character varying(100)
);


ALTER TABLE public.modules OWNER TO postgres;

--
-- Name: modules_module_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.modules_module_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.modules_module_id_seq OWNER TO postgres;

--
-- Name: modules_module_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.modules_module_id_seq OWNED BY public.modules.module_id;


--
-- Name: news; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.news (
    news_id integer NOT NULL,
    news_text text,
    news_source character varying(255),
    news_date timestamp without time zone
);


ALTER TABLE public.news OWNER TO postgres;

--
-- Name: news_news_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.news_news_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.news_news_id_seq OWNER TO postgres;

--
-- Name: news_news_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.news_news_id_seq OWNED BY public.news.news_id;


--
-- Name: notifications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notifications (
    notification_id bigint NOT NULL,
    user_id integer,
    notification_date timestamp without time zone,
    notification_text text
);


ALTER TABLE public.notifications OWNER TO postgres;

--
-- Name: notifications_notification_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notifications_notification_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.notifications_notification_id_seq OWNER TO postgres;

--
-- Name: notifications_notification_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notifications_notification_id_seq OWNED BY public.notifications.notification_id;


--
-- Name: rewards; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rewards (
    reward_id integer NOT NULL,
    reward_points integer
);


ALTER TABLE public.rewards OWNER TO postgres;

--
-- Name: rewards_reward_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.rewards_reward_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.rewards_reward_id_seq OWNER TO postgres;

--
-- Name: rewards_reward_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.rewards_reward_id_seq OWNED BY public.rewards.reward_id;


--
-- Name: tips_of_the_day; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tips_of_the_day (
    tip_id integer NOT NULL,
    tip_text text DEFAULT 'Something went wrong, no tip for today :('::text
);


ALTER TABLE public.tips_of_the_day OWNER TO postgres;

--
-- Name: tips_of_the_day_tip_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tips_of_the_day_tip_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tips_of_the_day_tip_id_seq OWNER TO postgres;

--
-- Name: tips_of_the_day_tip_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tips_of_the_day_tip_id_seq OWNED BY public.tips_of_the_day.tip_id;


--
-- Name: user_progress; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_progress (
    progress_id integer NOT NULL,
    user_id integer,
    challenge_id integer,
    is_completed boolean,
    completion_date timestamp without time zone
);


ALTER TABLE public.user_progress OWNER TO postgres;

--
-- Name: user_progress_progress_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_progress_progress_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_progress_progress_id_seq OWNER TO postgres;

--
-- Name: user_progress_progress_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_progress_progress_id_seq OWNED BY public.user_progress.progress_id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    user_id integer NOT NULL,
    email character varying(255) NOT NULL,
    username character varying(25) NOT NULL,
    password character(161) NOT NULL,
    is_admin boolean DEFAULT false NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_userid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_userid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_userid_seq OWNER TO postgres;

--
-- Name: users_userid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_userid_seq OWNED BY public.users.user_id;


--
-- Name: challenges challenge_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.challenges ALTER COLUMN challenge_id SET DEFAULT nextval('public.challenges_challenge_id_seq'::regclass);


--
-- Name: lessons lesson_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lessons ALTER COLUMN lesson_id SET DEFAULT nextval('public.lessons_lesson_id_seq'::regclass);


--
-- Name: modules module_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.modules ALTER COLUMN module_id SET DEFAULT nextval('public.modules_module_id_seq'::regclass);


--
-- Name: news news_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.news ALTER COLUMN news_id SET DEFAULT nextval('public.news_news_id_seq'::regclass);


--
-- Name: notifications notification_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications ALTER COLUMN notification_id SET DEFAULT nextval('public.notifications_notification_id_seq'::regclass);


--
-- Name: rewards reward_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rewards ALTER COLUMN reward_id SET DEFAULT nextval('public.rewards_reward_id_seq'::regclass);


--
-- Name: tips_of_the_day tip_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tips_of_the_day ALTER COLUMN tip_id SET DEFAULT nextval('public.tips_of_the_day_tip_id_seq'::regclass);


--
-- Name: user_progress progress_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_progress ALTER COLUMN progress_id SET DEFAULT nextval('public.user_progress_progress_id_seq'::regclass);


--
-- Name: users user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN user_id SET DEFAULT nextval('public.users_userid_seq'::regclass);


--
-- Data for Name: challenges; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.challenges (challenge_id, lesson_id, reward_id, challenge_text, challenge_answer) FROM stdin;
1	1	1	There is a risk of SQL injection modifying database data (yes/no)	yes
2	1	2	What can attacker insert into username field to log in without password? SELECT * FROM users WHERE username = '$username' AND password = '$password'; (give exact same answer as in the text)	' OR '1'='1
\.


--
-- Data for Name: leaderboard; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.leaderboard (user_id, points_challenges) FROM stdin;
49	0
47	50
50	0
48	150
51	0
\.


--
-- Data for Name: lessons; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.lessons (lesson_id, module_id, lesson_name) FROM stdin;
1	1	SQL Injection
3	1	File Inclusion
4	2	Linux commands
5	2	Bash
2	1	Cross-Site Scripting
\.


--
-- Data for Name: modules; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.modules (module_id, module_name) FROM stdin;
1	ATTACK
2	GENERAL
3	DEFENCE
\.


--
-- Data for Name: news; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.news (news_id, news_text, news_source, news_date) FROM stdin;
2	Rosyjscy hackerzy zaatakowali pocztę HP i Microsoftu	https://niebezpiecznik.pl/post/rosyjscy-hackerzy-zaatakowali-poczte-hp-i-microsoftu/	2024-01-27 15:17:49
1	Logi applowego AirDropa pozwalają na ustalenie tożsamości nadawcy. Chińskie władze pochwaliły się, że dysponują narzędziem do deanonimizacji nadawców „niebezpiecznych treści”.	https://sekurak.pl/logi-applowego-airdropa-pozwalaja-na-ustalenie-tozsamosci-nadawcy-chinskie-wladze-pochwalily-sie-ze-dysponuja-narzedziem-do-deanonimizacji-nadawcow-niebezpiecznych-tresci/	2024-01-25 10:52:00
\.


--
-- Data for Name: notifications; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notifications (notification_id, user_id, notification_date, notification_text) FROM stdin;
6	47	2024-01-30 13:48:37.315151	Welcome to the HackTheRoot, good luck!
7	48	2024-01-30 13:50:45.198452	Welcome to the HackTheRoot, good luck!
8	49	2024-01-30 13:51:44.568863	Welcome to the HackTheRoot, good luck!
9	50	2024-01-30 21:28:22.341366	Welcome to the HackTheRoot, good luck!
10	51	2024-01-30 21:36:49.553502	Welcome to the HackTheRoot, good luck!
\.


--
-- Data for Name: rewards; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.rewards (reward_id, reward_points) FROM stdin;
1	50
2	100
3	150
4	200
5	250
6	300
\.


--
-- Data for Name: tips_of_the_day; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tips_of_the_day (tip_id, tip_text) FROM stdin;
1	Keep amazing notes from day 1 of your work!
1	Draw a network map and identify user privilege
13	Test tip
\.


--
-- Data for Name: user_progress; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_progress (progress_id, user_id, challenge_id, is_completed, completion_date) FROM stdin;
9	48	1	t	2024-01-30 21:28:06.970006
10	48	2	f	2024-01-30 21:36:30.067727
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (user_id, email, username, password, is_admin) FROM stdin;
47	admin@htr.com	admin	80f6a8849c0b9ac00e1759b2ffc3eebe$079be645955eca92ffd8c17f73c169b8563cf4b0fe689e594296ce51c678be1591899f77d9d91d89009949840a7d052553d1c71ce16203570d01a9c2b7488549	t
48	user@htr.com	user	b2abfd6fca7ca731840148b08dd1040a$6e193f04cd2dd22a2f10b053c104ab401e2834eb06fbe94041e09af6642b4d71e5a4b2c455c73b288c38d62cea11a38fcf5d6d55d0da3e9c1365e75baea28a56	f
49	user2@htr.com	user2	752779df551d169e7259ddd8d2810476$d0762557e687157a809949b037e4c812ed7ec0f2c4c747ba0332726e2d6408a278e5a5c0a0553f7504626224ded8e6aa606808e6ad477f1a981171a20dcc5e00	f
50	user3@htr.com	user3	f6b6bc73074bb77b4432807746740008$a80391a3bdfe5035b47b745d40f480d83f46ff9c271e4a82ad54fee45502e22545073a39ce47583b6c6db83f50322d8141cc77a9ed4d9e0763282c9ef980bdf2	f
51	user4@htr.com	user4	61487d400f9a460bc52722f393c4c1ab$d2fce086caf49f32d4b22340001c344ccecbca634ef52d4ee1e31e50c4887399203aff9884a9044f01636413792ef128ef099f86fe160492d665f2de18838e2e	f
\.


--
-- Name: challenges_challenge_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.challenges_challenge_id_seq', 1, true);


--
-- Name: lessons_lesson_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lessons_lesson_id_seq', 1, true);


--
-- Name: modules_module_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.modules_module_id_seq', 3, true);


--
-- Name: news_news_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.news_news_id_seq', 3, true);


--
-- Name: notifications_notification_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notifications_notification_id_seq', 10, true);


--
-- Name: rewards_reward_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.rewards_reward_id_seq', 1, false);


--
-- Name: tips_of_the_day_tip_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tips_of_the_day_tip_id_seq', 13, true);


--
-- Name: user_progress_progress_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_progress_progress_id_seq', 10, true);


--
-- Name: users_userid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_userid_seq', 51, true);


--
-- Name: challenges challenges_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.challenges
    ADD CONSTRAINT challenges_pkey PRIMARY KEY (challenge_id);


--
-- Name: lessons lessons_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lessons
    ADD CONSTRAINT lessons_pkey PRIMARY KEY (lesson_id);


--
-- Name: modules modules_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.modules
    ADD CONSTRAINT modules_pkey PRIMARY KEY (module_id);


--
-- Name: news news_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.news
    ADD CONSTRAINT news_pkey PRIMARY KEY (news_id);


--
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (notification_id);


--
-- Name: rewards rewards_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rewards
    ADD CONSTRAINT rewards_pkey PRIMARY KEY (reward_id);


--
-- Name: leaderboard unique_user_leaderboard; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.leaderboard
    ADD CONSTRAINT unique_user_leaderboard PRIMARY KEY (user_id);


--
-- Name: user_progress user_progress_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_progress
    ADD CONSTRAINT user_progress_pkey PRIMARY KEY (progress_id);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- Name: users users_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- Name: users trigger_add_welcome_notification; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_add_welcome_notification AFTER INSERT ON public.users FOR EACH ROW EXECUTE FUNCTION public.add_welcome_notification();


--
-- Name: user_progress trigger_update_leaderboard_points; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_update_leaderboard_points AFTER INSERT OR UPDATE OF is_completed ON public.user_progress FOR EACH ROW WHEN ((new.is_completed = true)) EXECUTE FUNCTION public.update_leaderboard_points();


--
-- Name: challenges challenges_lesson_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.challenges
    ADD CONSTRAINT challenges_lesson_id_fkey FOREIGN KEY (lesson_id) REFERENCES public.lessons(lesson_id);


--
-- Name: challenges challenges_reward_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.challenges
    ADD CONSTRAINT challenges_reward_id_fkey FOREIGN KEY (reward_id) REFERENCES public.rewards(reward_id);


--
-- Name: leaderboard fk_leaderboard_user; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.leaderboard
    ADD CONSTRAINT fk_leaderboard_user FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- Name: lessons lessons_module_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lessons
    ADD CONSTRAINT lessons_module_id_fkey FOREIGN KEY (module_id) REFERENCES public.modules(module_id);


--
-- Name: notifications notifications_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- Name: user_progress user_progress_challenge_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_progress
    ADD CONSTRAINT user_progress_challenge_id_fkey FOREIGN KEY (challenge_id) REFERENCES public.challenges(challenge_id);


--
-- Name: user_progress user_progress_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_progress
    ADD CONSTRAINT user_progress_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

