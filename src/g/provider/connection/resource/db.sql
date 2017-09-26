CREATE TABLE user (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    department_id bigint DEFAULT 1,
    first_name character varying(255) NOT NULL,
    last_name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character(60),
    force_password_change integer DEFAULT 1 NOT NULL,
    is_active boolean NOT NULL,
    entry_date timestamp with time zone DEFAULT now() NOT NULL,
    entry_by character varying(255) DEFAULT 'Unknown'::character varying NOT NULL,
    last_modified_date timestamp with time zone DEFAULT now() NOT NULL,
    last_modified_by character varying(255) DEFAULT 'Unknown'::character varying NOT NULL    
);