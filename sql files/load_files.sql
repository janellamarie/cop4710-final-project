LOAD DATA INFILE 'cop4710-final-project\\data\\animals.csv'  # change to directory of files
INTO TABLE animals
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'cop4710-final-project\\data\\users.csv' # change to directory of files
INTO TABLE users
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;