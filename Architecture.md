# Architecture Template

## 1. Stakeholders

The direct stakeholders consists of:

* Client
  * These are the players conversing with the interactive frontend of our architecture. Their boundaries start and end in the tangible product shown on display to the world.
* Designing Engineers
  * These are the players who maintain and develop the interactable product the clients engage with. They work with feedback obtained from the client to preserve the quality of the frontend and converse with the backend engineers to coordinate further development limitations and freedom.
* Backend Engineers
  * These are the players who engage in the development, maintenance, and research of the backend database. Both high level technological solution designing and low level implementations, while coordinating with design engineers on practical limitations on the connection of backend and frontend architecture.
* Privacy Directors
  * High level technological solution designing for backend architecture revolving around correct and strong security. Inspection, examination, and auditing the security integrity of the frontend, backend, and the connection and interaction of the two.

## 2. Architectural Design Decisions

Many architectural design decisions were discussed and concluded with the goal of achieving heightened privacy security for the clients. For each design implementation, the privacy advantages were thoroughly assessed with tradeoffs, both of intractability and implementation elegance, in mind and taken into account.

### Single Unique Identifier Account System

Clients are given a unique and randomly generated 16-digit ID on account creation. Clients must use this 16-digit ID to log in and use our system under the corresponding account the client wishes to use. This unique ID is the primary key for user logging in the backend server.

[+ Hashed using strong one-way hashing algorithm bcrypt which means cannot be retrieved by us +]

The tradeoffs for this design decision affects the implementation and maintenance of the backend database and the client usability of our frontend product.

* Inconvenience for user logging in every time login memory cookie expires.
* Efficiency decline on data fetching for frontend display.

An alternative method was to have a traditional username and password system where the user has autonomy in choosing the two. We rejected this option because of the following tradeoffs we deemed too detrimental to overall privacy.

* Existence of pseudonymized data poses vulnerabilities to identification.
* User account vulnerabilities from external breaches providing username and/or password combination existing on our database (as many people use similar usernames and/or passwords for all their services).

Overall, our decision to apply this architectural design was for the following reasons.

* Minimize any links of user inputted data to corresponding user's identity, either directly or by proxy.
* Circumvent user-created vulnerabilities to their accounts, such as simple passwords or repeated use of breached username and password combination.

[+ Add proof of security with account IDs +]

### E2EE Based on Unique Identifier

End-to-end encryption (E2EE) is a security protocol designed to protect communications by encrypting messages in a way that only the intended recipients can access the information. This means that the data is encrypted on the sender's device, and can only be decrypted by the intended recipient's device. In an end-to-end encryption system, the encryption keys used to encrypt and decrypt the messages are only known by the sender and the recipient. Our encryption system takes a different route and has it so the encryption key is only held by the user, in the form of their 16-digit identifier. [+ Emphasis on fact that we cannot get their data +]

[+ New section for master database? It's an entire different subject +]
We use traditional E2EE on a separate database for users who opt-in to providing an email for future account recovery purposes, ensuring that we will be able to decrypt their identifier on our separate database and provide it for our users who have lost it. [+ no more email, we still cannot decrypt the identifiers in the master database, it's there for our algorithm. The ids are converted into a blind index for us to be able to group users in our database without being able to know what their id is, using sodium_crypto_pwhash algorithm +]

The tradeoffs for this architectural design decision affects user convenience.

* No possibility of data retrieval in the case of a user losing their identification code and have not opted in for account recovery. 
* No username to identify users in database means that everything is encrypted using AES, leading to less efficient data pulls.

One alternative to this encryption method is the traditional end-to-end encryption where both the sender (data subject) and receiver (OvaView) both hold the encryption key. This alternative was rejected because of one main disadvantage.

* No fail-safe preventing server from decrypting data subjects' information. [+ hmm we have that disadvantage with the master table, no? +]
* More vulnerabilities revealed by one more entity holding the encryption key.

Our decision to create a dichotomy where the server is unable to decrypt data creates less flexibility, but increased security. The privacy benefits include the following aspects.

* Peace of mind for user knowing any entity not holding the unique identifier is unable to read data.
* Increased simplicity to secure all possible vulnerabilities.

### Exclusion of Cookies

We exclude the usage of third party cookies in our webapp. This means that there our system does not create any cookies on the user's device that communicates with any domain outside of ours. Moreover, we also ensure the lack of cookies mean that even we are not collecting any data on the user while they use our service.

This architectural design policy offers no tradeoffs with respect to user privacy. One could argue this implementation negatively impacts user convenience.

* Users will not have the option of receiving advertisements outside our domain specifically enhanced from the data they submitted to our system.
* Users will be required to log in every time they start a new session.

An alternative decision we could have made would have been to make use of third-party cookies to communicate information with other domains. To put bluntly, we rejected this option swiftly for the following disadvantage.

* As a privacy-minded company, the mere existence of third-party cookies poses a threat to the integrity of our system's fulfillment to prioritize user data protection; one that is not worth risking at the cost of potential quality of life for a portion of our userbase.

This architectural decision provides the following benefits to user privacy protection on our app.

* No disclosure of user data to third parties.
* No tracking of user activity and user data on our service.
* Ensure no tracking from OvaView of the user.
* Clear transparency for the user of the service/consumer dichotomy.

## 3. Architectural Models

UML BABY

## 4. Important Scenarios

### User registration

This scenario is occurred when the user interacts with the onboarding page. Upon initiation, the back-end of our app on the local device will do the following:

* Generate a random 16-digit identifier.
* Verify uniqueness of identifier.
  * Retrieve hashed existing UID table from server
  * Compare with hashed table to detect existence of new UID
  * If randomly generated identifier already exists, generate a new one and retry
* Encrypt unique identifier and transfer to server for instantiation in our system.

After the new account is legitimized on our app, the user is displayed their UID to take note and keep safe. Then, the front-end is redirected to our landing page so the user can log in to their new account (which in parallel, ensures the user took note of their UID). 

### User login

Prior to login, the front-end does not have a dashboard page, as there is no user stored in the browser session. User's are required to input their only their UID to log in to our system. Our back-end verifies every user log in attempt with the following protocol:

* Retrieve hashed existing UID table from server
* Verify existence of inputted UID via hashing for efficiency
* If existence of inputted UID is verified, return success
* If inputted UID does not exist, return failure

Upon failure, the user will be prompted to retry with another UID. Success will successfully log in the user, and store their verified status in the browser session.

Upon success, the user's 16-digit identifier is stored on the local device's back-end code in a browser session array object. Moreover, logged in status will create two new options in the website header the user will be able to see and interact with.

* Access to personal dashboard
* Access to personal account settings

No information about user logins is stored in our database.

### Dashboard Data Viewing and Submission/Rectification/Deletion

Upon entering the personal dashboard, users will be able to interact with the calendar user-interface, allowing for 4 different actions per calendar-date.

* Entry viewing
* Entry submission
* Entry modification/rectification
* Entry deletion

Entry viewing is done by simply clicking on dates with an existing entry; all data on the user is retrieved by the front-end from the back-end by filtering through the table of logs using the user's 16-digit identifier they submitted to log in (which is stored in the browser session). All user data retrieved is decrypted using the same 16-digit identifier stored in the session.

Entry submission is initiated by the following protocol:

* Clicking the "add entry" button will create a form object in which the user's selected parameters and input is stored.
* Clicking the "ok" button will
  * encrypt all the data in the form object,
  * create a JSON object holding all the encrypted data,
  * and finally transfer the data to the server.

Entry modification/rectification is achievable only on calendar-dates that hold an existing entry; empty dates will not have this option for users.

* Clicking the "edit entry" button will create a form object pre-loaded with the respective existing data, in which the user can modify the displayed information.
* Clicking the "ok" button will
  * encrypt all the data in the form object,
  * create a JSON object holding all the encrypted data,
  * and pull the calendar-date from this data object.
* Using the calendar-date and UID (submitted by user on login), we can filter through our table of entries to find our target entry of modification, using a 1-way hashing method. Once found, we will transfer the data to the server using an SQL update method.

Entry deletion, like modification, is only available when an entry on a date exists.

* Clicking the "delete entry" button will parse the date of the target entry.
* Find entry using the date and UID (submitted by user on login) in database and call an SQL delete command on row.

### Request for Data Deletion

One of the features the user can initiate in the settings tab is data deletion: the user can choose to request

* deletion of all date entries linked to their account
* deletion of account

Request for the deletion of all date entries will, following the its name, delete all logs tied to the UID of the user logged in all at once. This will be done by the following protocol:

* Retrieve table of all entries from the server
* Scan entries by hashing UID stored in session
* Call SQL delete row on every hit

Request for the deletion of user account will first do the same protocol as above for deletion of all entries. Then, it will do the following:

* Retrieve table of all users from the server
* Scan users by hashing UID stored in session
* Call SQL delete row on user row

After this is done, the user will be logged out of their (now non-existent account) and be sent to the landing page of our website.

### Opt-in / Opt-out

The other feature available to users in the settings tab is to opt-in or opt-out (depending on the current user state) of our advanced period prediction algorithm. Switching consent (because this option is essentially a Boolean flip) will enact the following protocol:

* Retrieve current consent status in the form of a Boolean from table of users in database using UID (submitted by user on login)
* Flip status of consent and encrypt parameter
* Update consent parameter of corresponding user to flipped status using SQL update command

Due to complications with encryption, the database does not hold Booleans, but rather integers corresponding to on or off statuses.

Once a user is opted in to this feature, the user will receive more accurate predictions on their calendar UI.

On the server, a few more changes occur. Firstly, there is a separate table in our database that is functionally the same as the initial table holding all user entries; this table differs in the way rows are encrypted, where now the server also holds the encryption key. This allows us to read the rows of this table for further R&D and processing for the stated reasons the user has consented to.

Opted in users have their entry submission/deletion/modification mirrored to this table; instead of just one protocol for data manipulation by the user, there are two running in parallel. The new protocol looks similar to the initial one with one major change, where the data is encrypted using a shared key, that the user and server have possession of.

Opted out users are exempt from this extra data flow.

### User Logout

Logged in users have the option to log out of their account. Clicking the logout button will reset the local session variable, meaning their UID they used to log in is gone from any storage on the local device. Users are redirected back to the landing page of our website, with the access to all logged in features gone due to the lack of UID stored in the session variable.

No information about user logouts is stored in our database.
