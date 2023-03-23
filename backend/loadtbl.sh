#!/bin/bash
sqlite3 periodTracking.db  "insert into logs (id_crypt, entry) values \
    ('3453', 'Today was a good day.'), \
    ('4827', 'I miss my dog.'), \
    ('4736', 'I feel super motivated, more than yesterday!') \
    ;"

sqlite3 periodTracking.db  "insert into users (id) values (3453), (4827), (4736);"