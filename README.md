#Faculty Publications Portal
A web-based portal built using PHP that allows faculty members to upload and manage their academic publications, such as IEEE papers, while providing administrative controls for managing users and generating reports.

#Features
Faculty Login: Faculty members can securely log in to the portal to manage their publications.

Upload Publications: Faculty members can upload their publications, including IEEE papers, and categorize them for easy access.

Admin Controls: Admins can manage faculty accounts, approve/reject publications, and generate reports on the uploaded publications.

Report Generation: Admins can generate detailed reports on faculty publications and track upload statistics.

#Requirements
PHP 7.x or higher

MySQL or MariaDB for the database

Apache or Nginx server

Basic understanding of HTML, CSS, and JavaScript

#Installation
Clone the repository
bash
Copy
Edit
git clone https://github.com/yourusername/faculty-publications-portal.git
cd faculty-publications-portal
#DATABASE QUERY
faculty login/registration:
CREATE TABLE faculty (
    faculty_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL, -- It's a good practice to store hashed passwords
    department VARCHAR(100) NOT NULL,
    mobileno VARCHAR(15) NOT NULL, -- Adjust length as needed
    publication_text TEXT, -- If you want to store publication text or notes
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
Faculty publiactions
CREATE TABLE publications (
    publication_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    faculty_id VARCHAR(50) NULL,
    title VARCHAR(255) NULL,
    authors VARCHAR(150) NOT NULL,
    journal_title VARCHAR(255) NULL,
    volume VARCHAR(50) NULL,
    issue VARCHAR(50) NULL,
    page_start INT(11) NULL,
    page_end INT(11) NULL,
    publish_date DATE NULL,
    e_issn VARCHAR(50) NULL,
    print_issn VARCHAR(50) NULL,
    affiliation VARCHAR(255) NULL,
    doi VARCHAR(255) NULL,
    web_link VARCHAR(255) NULL,
    article_link VARCHAR(255) NULL,
    conference_proceeding ENUM('Yes', 'No') NULL,
    scie_category ENUM('SCIE', 'SCI', 'ESCI', 'Scopus', 'UGC', 'OA') NULL,
    impact_factor DECIMAL(5,2) NULL,
    quartile_category ENUM('Q1', 'Q2', 'Q3', 'Q4') NULL,
    academic_year VARCHAR(10) NULL,
    calendar_year INT(11) NULL,
    FOREIGN KEY (faculty_id) REFERENCES faculty(faculty_id) -- Assumes 'faculty' table exists with faculty_id as primary key
);

