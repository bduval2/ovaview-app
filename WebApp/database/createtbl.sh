#!/bin/bash
sqlite3 periodTracking.db  "create table logs (id_crypt TEXT PRIMARY KEY, mood TEXT, symptoms TEXT, note TEXT, year TEXT, month TEXT, day TEXT);"
sqlite3 periodTracking.db  "create table users (id_crypt TEXT PRIMARY KEY, consent TEXT);"
sqlite3 periodTracking.db  "create table master_logs (id_crypt TEXT, mood TEXT, symptoms TEXT, year TEXT, month TEXT, day TEXT);"
