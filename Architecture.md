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

The tradeoffs for this design decision affects the implementation and maintenance of the backend database and the client usability of our frontend product.

* Inconvenience for user logging in every time login memory cookie expires.
* Efficiency decline on data fetching for frontend display.

An alternative method was to have a traditional username and password system where the user has autonomy in choosing the two. We rejected this option because of the following tradeoffs we deemed too detrimental to overall privacy.

* Existence of pseudonymized data poses vulnerabilities to identification.
* User account vulnerabilities from external breaches providing username and/or password combination existing on our database (as many people use similar usernames and/or passwords for all their services).

Overall, our decision to apply this architectural design was for the following reasons.

* Minimize any links of user inputted data to corresponding user's identity, either directly or by proxy.
* Circumvent user-created vulnerabilities to their accounts, such as simple passwords or repeated use of breached username and password combination.
* <mark>Please ask @bduval2 if any technological advantages exist. Is encryption based on ID better here on a section of its own?</mark>

### E2EE Based on Unique Identifier

<mark>Would like @bduval2 to offer some guidance as I am less fluent in the encryption method.</mark>

End-to-end encryption (E2EE) is a security protocol designed to protect communications by encrypting messages in a way that only the intended recipients can access the information. This means that the data is encrypted on the sender's device, and can only be decrypted by the intended recipient's device. In an end-to-end encryption system, the encryption keys used to encrypt and decrypt the messages are only known by the sender and the recipient. Our encryption system takes a different route and has it so the encryption key is only held by the user, in the form of their 16-digit identifier.

We use traditional E2EE on a separate database for users who opt-in to providing an email for future account recovery purposes, ensuring that we will be able to decrypt their identifier on our separate database and provide it for our users who have lost it.

The tradeoffs for this architectural design decision affects user convenience.

* No possibility of data retrieval in the case of a user losing their identification code and have not opted in for account recovery.

### Exclusion of Third Party Cookies

We exclude the usage of third party cookies in our webapp. This means that there our system does not create any cookies on the user's device that communicates with any domain outside of ours. We exclusively use one first party cookie to remember a user's login session for up to 30 days.

This architectural design policy offers no tradeoffs with respect to user privacy. One could argue this implementation has one negative.

* Users will not have the option of receiving advertisements outside our domain specifically enhanced from the data they submitted to our system.

An alternative decision we could have made would have been to make use of third-party cookies to communicate information with other domains. To put bluntly, we rejected this option swiftly for the following disadvantage.

* As a privacy-minded company, the mere existence of third-party cookies poses a threat to the integrity of our system's fulfillment to prioritize user data protection; one that is not worth risking at the cost of potential quality of life for a portion of our userbase.

This architectural decision provides the following benefits to user privacy protection on our app.

* No disclosure of user data to third parties.
* No tracking of user activity and user data on our service.
* Clear transparency for the user of the service/consumer dichotomy.

## 3. Architectural Models

UML BABY

## 4. Important Scenarios

For each important scenario, record the initial system state and environment, the external stimulus, and the required and actual system behavior. Again, it may be appropriate to provide an overview here and refer readers to an appendix for more details.

An architectural scenario is a well-defined description of an interaction between an external entity and the system. It defines the event that triggers the scenario, the interaction initiated by the external entity, and the response required of the system.

Scenarios:

* User login / sign up
* User data input
* Opt-in/out changes

Use UML for this probably. . .

CHAPTER 10 IN BOOK
