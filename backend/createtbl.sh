#!/bin/bash
sqlite3 periodTracking.db  "create table logs (id_crypt TEXT PRIMARY KEY, entry TEXT);"
sqlite3 periodTracking.db  "create table users (id_crypt TEXT PRIMARY KEY);"