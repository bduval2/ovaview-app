#!/bin/bash
sqlite3 periodTracking.db  "create table logs (id_crypt INTEGER PRIMARY KEY, entry TEXT);"
sqlite3 periodTracking.db  "create table users (id INTEGER PRIMARY KEY);"