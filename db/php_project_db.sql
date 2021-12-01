CREATE TABLE course (
	course_id	CHAR(8) NOT NULL,
	title	VARCHAR(100) NOT NULL,
	credits	TINYINT(1) UNSIGNED NOT NULL,
	PRIMARY KEY (course_id)
);

CREATE TABLE section (
	course_id	CHAR(8) NOT NULL,
	section_id	CHAR(3) NOT NULL,
	capacity	TINYINT(1) UNSIGNED NOT NULL,
	PRIMARY KEY (course_id, section_id),
	FOREIGN KEY (course_id)
		REFERENCES course (course_id) ON DELETE NO ACTION
);

CREATE TABLE student (
	student_id	VARCHAR(30) NOT NULL,
	password	VARCHAR(255) NOT NULL,
	name	VARCHAR(50),
	year_of_study	TINYINT(1) UNSIGNED NOT NULL,
	PRIMARY KEY (student_id)
);

CREATE TABLE enrollments (
	student_id	VARCHAR(30) NOT NULL,
	course_id	CHAR(8) NOT NULL,
	section_id	CHAR(3) NOT NULL,
	status	TINYINT(1) UNSIGNED NOT NULL,
	PRIMARY KEY (student_id, course_id),
	FOREIGN KEY (student_id)
		REFERENCES student (student_id) ON DELETE NO ACTION,
	FOREIGN KEY (course_id, section_id)
		REFERENCES section (course_id, section_id) ON DELETE NO ACTION
);
