#!/bin/bash
sqlite3 periodTracking.db  "drop table logs;"
sqlite3 periodTracking.db  "drop table users;"
sqlite3 periodTracking.db  "drop table master_logs;"