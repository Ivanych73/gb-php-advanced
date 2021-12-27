--
-- PostgreSQL database dump
--

-- Dumped from database version 10.12
-- Dumped by pg_dump version 10.12

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
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: catalog; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.catalog (
    id integer NOT NULL,
    title character varying(63),
    price numeric(12,0),
    description text
);


ALTER TABLE public.catalog OWNER TO postgres;

--
-- Name: catalog_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.catalog_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.catalog_id_seq OWNER TO postgres;

--
-- Name: catalog_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.catalog_id_seq OWNED BY public.catalog.id;


--
-- Name: images; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.images (
    id integer NOT NULL,
    title character varying(63),
    good_id integer
);


ALTER TABLE public.images OWNER TO postgres;

--
-- Name: goods_list; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.goods_list AS
 SELECT images.title AS image_title,
    catalog.description,
    catalog.price,
    catalog.title AS good_title,
    catalog.id AS good_id
   FROM (public.images
     JOIN public.catalog ON ((images.good_id = catalog.id)));


ALTER TABLE public.goods_list OWNER TO postgres;

--
-- Name: images_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.images_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.images_id_seq OWNER TO postgres;

--
-- Name: images_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.images_id_seq OWNED BY public.images.id;


--
-- Name: catalog id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.catalog ALTER COLUMN id SET DEFAULT nextval('public.catalog_id_seq'::regclass);


--
-- Name: images id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.images ALTER COLUMN id SET DEFAULT nextval('public.images_id_seq'::regclass);


--
-- Data for Name: catalog; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.catalog VALUES (1, 'Два толстых котика', 55, 'Два толстых котика удивленно глядят из дверного проема');
INSERT INTO public.catalog VALUES (3, 'Наглый котик "коровка"', 48, 'Наглый котик расцветки "коровка" оперся передними лапами о другого черного котика');
INSERT INTO public.catalog VALUES (5, 'Толстый полосатый котик', 39, 'Толстый полосатый котик просто зевает');
INSERT INTO public.catalog VALUES (7, 'Рыжий котик', 41, 'Рыжий котик умильно спит');
INSERT INTO public.catalog VALUES (8, 'Два белых котика', 62, 'Два белых котика вылизывают друг дружку.');
INSERT INTO public.catalog VALUES (9, 'Бело-рыжий котенок', 49, 'Бело-рыжий котенок очень серьезно смотрит на Вас');
INSERT INTO public.catalog VALUES (10, 'Британцы в шапочках', 58, 'Два британских котика в смешных шапочках сидят на диване с очень важным видом');
INSERT INTO public.catalog VALUES (11, 'Толстый белый', 42, 'Толстый белый котик, в шапочке, как корона 18 века, сидит враскоряку');
INSERT INTO public.catalog VALUES (12, 'Двое на подоконнике', 82, 'Серый и рыжий котики летним днем наблюдают за чем-то с подоконника');


--
-- Data for Name: images; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.images VALUES (1, '1.jpg', 1);
INSERT INTO public.images VALUES (2, '2.jpg', 3);
INSERT INTO public.images VALUES (5, '3.jpg', 5);
INSERT INTO public.images VALUES (6, '4.jpg', 7);
INSERT INTO public.images VALUES (7, '5.jpg', 8);
INSERT INTO public.images VALUES (8, '6.jpg', 9);
INSERT INTO public.images VALUES (9, '7.jpg', 10);
INSERT INTO public.images VALUES (10, '8.jpg', 11);
INSERT INTO public.images VALUES (11, '9.jpg', 12);


--
-- Name: catalog_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.catalog_id_seq', 1, false);


--
-- Name: images_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.images_id_seq', 1, false);


--
-- Name: catalog catalog_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.catalog
    ADD CONSTRAINT catalog_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

