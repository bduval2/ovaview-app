# **Report Document**

**do citations after because md citations are the worst thing ive ever fucking dealt with in my entire life jfcccccccc ANY STUFF THAT LOOKS NOT THAT DETAILED WILL CITE TO A DETAILED PART IN ONE OF THE DOCS DO NOT WORRY**

## Overview of the System

### Our Company

OvaView aims to simplify the monitoring and organizing of menstrual cycles for users. The period tracker provides a platform to eloquently track, organize, and predict your menstrual health all while keeping your privacy safe and secure. Our system aims to provide a stress-free and elegant way to stay on top of your body's health while ensuring no one else but you gets to track this intimate data.

Our app, in essence, is a simple calendar-style tracker. We offer a mutable calendar UI to each user that can be filled day by day with notes and symptoms related to their menstrual health. There exists one additional feature that users are given opportunities to opt-in to, where the personalized notes they submit are processed by our proprietary prediction algorithm to receive forecast of future menstrual activity.

### Our Mission

Our goal of putting privacy as the top priority galvanized us to uphold specific privacy requirements.

1. Fair and transparent data collection and processing
2. Responsible data retention
3. Responsible data storage and security

These privacy etiquettes synergize to incorporate the best privacy by design policies together with strong architectural design decisions to provide users with the best protection of their privacy, all the while maintaining minimal tradeoffs to the overall user experience. 

It is our mission at OvaView to provide everyone an anonymous, secure, and effective way to stay on top of your menstrual health.

### The Stakeholders

Due to the app's simplistic nature, small development team, and primary goal to maximize user privacy, the stakeholders in our system are few in number. The first would be the _user_, who interacts with our front-end to make use of our service and manipulate their corresponding data in our servers. The next would would be the _front-end_ and _back-end engineers_ who respectively maintain and develop the product users interact with and the architecture handling data flow. The last stakeholder in our system would be the _privacy director_, who plays the role of ensuring and maintaining proper privacy practice in the implementation and development of our product, as well as supervising the training of all employees in our company of the importance of company information security to ensure both the artificial and human vulnerabilities of our system are covered. After all, the vast majority of data breaches reported in recent times have been due to human error rather than an architectural failure **\[cite here\]**.

### The Menstrual Health Resources Currently

The period tracking ecosphere is an almost $4 billion market, yet a fully privacy-minded option is yet to exist [^1]. Women experiencing difficulty managing their menstrual health deserve free access to the resources and aid they need, all the while finding solace in the fact that their intimate details will be kept secret to only themselves. Unfortunately, every app and service existing on the market follow a profit oriented design policy; the truth of the matter is that in our digital world today, you and your data are the product [^2].

To illustrate the harsh reality for period trackers, the two of the largest (by active user count) period tracking apps on both Google and iOS have many vulnerabilities threatening the integrity of user privacy of their systems. _Flo_, the most popular period tracking app, has been egregious enough in their questionable data policies that multiple class action lawsuits have been filed against them for selling named and identified data to major media and advertising companies [^3]. _Clue_, which has been widely regarded as the most privacy-safe options women have on the market, remains to exercise dubious policies and practices. _Clue_, like every other period tracker, requires users to submit their identity to access their service: name, date of birth, city, email, phone number, and more are required fields to submit to create an account. Moreover, instead of letting users choose how to use their product, _Clue_ locks their product behind intimate questions users must answer to proceed onto the main functionalities of the app; inquiries such as sexual activity, sexual habits and symptoms, descriptive details about menstrual activity, and many more. Damning of all, _Clue_ sends their data off to researchers, with the promise that all the data is anonymized; except said data do not censor location of users, making the data easily identifiable and poorly anonymized by concept [^4].

The current landscape of period trackers is not an anomaly; the trend of every service, regardless of whether or not its function requires identified data to perform its job, requiring consumers to submit an abundance of personal information has been around for the past decade and further. Be it calculator or grocery list app, every company is taking advantage of our population becoming more and more normalized to submitting our names and details to receive any online product. This trend is what OvaView sets to confront; our company policies and principles are deliberate, with the goal of differentiating ourselves from the rest of our competition. To provide a service that users can be confident that their data and privacy is safe and in their control, while receiving the quality resources to take care of their health they deserve [^5] [^6].

## Design and Implementation

### Unique Design Choices

OvaView has precise, unique design decisions that are worth highlighting and describing their benefits to user privacy.

* Our website uses no cookies.
  * Despite some inconveniences to users, such as no persistent logins or, debatably, personalized ads on other platforms based on user activity on our domain, we maintain a strict policy to never track our users on our site. We aim for full confidence from our users that we never look at what they do on our system, and the existence of any cookies would prove as a threat to that promise.
* Our anonymous account system.
  * User accounts are identified by a generated 16-digit string, nothing else.
  * By refusing to accept any sort of username/password combination from users, and appointing 16-digit UIDs, we take advantage of the increased anonymity in our system. This would require more responsibility from the user to remember an artificial identifier, but it stamps out the possibility of users being identified from any of the data they submit to our database.
* No data submission required to join.
  * OvaView recognizes our app has no need for standard account registration details. Name, date of birth, email, phone number, etc. are useless to us and our mission, which is why none of them are needed, nor wanted, when a person wishes to sign up. This absolute anonymity has its downfalls to convenience: account recovery is impossible as we have no way to verify account ownership other than knowledge of UID, and data manipulation of lost accounts is impossible, as the "owner" of the data disappears once knowledge of the UID is gone. Fortunately, our system ensures identification with data left in our system to be impossible, as no personally identifiable information is tied to any of our data points.
* Encryption via unique UID.
  * Our default database (for users not opted in for additional features) have their data encrypted uniquely: by their 16-digit UIDs. This implementation makes sure that nobody, not even us at OvaView, other than the data owner can decrypt their sensitive information.
* Your data is never our data.
  * OvaView maintains unconditional compliance to any requests regarding data associated with an authorized user.
  * This means users are guaranteed full mutability of their information in our database: viewership, rectification, and deletion are all functions available to the user at all times.
  * We never touch your data without your permission. Users can be assured that with our encryption system, we cannot even read your data.
  * And when you do give us permission, you still own it. We will never do any processing we do not disclose, and will still unconditionally follow any user requests for modification of data used in our additional opt-in feature.
* Focus on employee safe practice.
  * Many studies show the vast majority of data breaches are the symptom of awful employee practice; human error, social engineering of workers, phishing attacks, etc., the human aspect of systems proves to be the most volatile aspect. To cover that vulnerability, as well as keep users at peace of mind, we have strict policies of rigorously training our employees in safe privacy practices.

### How We Manage Our Privacy Requirements

Our company achieves the privacy requirements we set for ourselves of

1. Transparent and fair data collection and processing
2. Responsible data retention
3. Responsible data storage

by implementing precise design decisions to our infrastructure and architecture.

We want users to see the entire lifetime of their information in full detail; it is imperative to keep no secrets to achieve mutual respect between the user and service, which is why we take full responsibility in ensuring the user are fully aware of _what_ we require from the users, _how long_ we keep the data we collect, and _inform_ users that they are in full control over their data at all steps of our product process. Furthermore, we felt found it crucial to default users to the minimum data collection to run our service. We wanted to provide accurate menstrual cycle prediction to users, but realized this would require more data processing. We want users to have this option, but have full awareness of what this is all about before opting in.

Data retention can be scary for users: the modern-day fear being that anything posted online is etched into history forever. To combat this, we make sure to ensure users that they are in control of their data, that at any time they can request the viewing, rectification, and deletion of all data linked to their account, with no fickle statements from us trying to dissuade users. Our company chooses to maintain data until the user sees otherwise; because our account system requires no identifiable information whatsoever, none of the data in our servers are actually linked to the user in real life. Due to this, aggregation of data in our servers to identify our users is impossible, meaning the data users forget about and leave in our data to hibernate will never be a risk to their privacy; moreover, this means that users can always come back to our service after a break.

Consumers also want to make sure that any data they do submit is not going to be easily accessed by malicious actors or randomly spilled by the data handler out in public. Our architecture uses modern E2EE with a slight modification to keep our databases safe; the slight alteration being instead of both the sender and receiver of encrypted data holding the key, our system has it so only the user holds the key: their 16-digit UID. This means that all user data is completely unreadable to everyone except the owner; even us, the company maintaining the infrastructure would be unable to decrypt user data. However, the situation is different for users who opt-in to our period prediction feature; their data is additionally stored in a secure database structure that uses traditional E2EE.

### Our Period Prediction Feature

The more secure the system, the less features you will get. It is a fact that no developer can bend, turn, nor rip up. OvaView sees the value in foresight when it comes to menstrual health; being able to anticipate and prepare for your next period is an invaluable quality of life we wish to provide for our users.

Our company provides this feature, but behind a consent notice. We cannot defy logic and provide users accurate predictions without processing their data; and we want users to be aware of this before they opt-in. We make sure to default all users who register to be opted-out, as no one likes being snuck into extra procedures they were not fully aware of. Users are only able to opt-in after fully reading all the consequences of opting in. Implications of their data such as:

* OvaView will extract from subsequent entries after opting in of the mood, period symptoms, and dates to store in a separate database.
* OvaView has the ability to decrypt and read said information extracted.
* OvaView will use the information to analyze your health status to provide accurate results.

To remain transparent and consistent, we maintain the level of authority users have over their data. Users are able to opt-out at any time they choose, and request deletion of all data that are being stored and processed for our period prediction feature. We continue to ensure that we do not own any of the data they consent to give for prediction purposes, nor will we use them for reasons other than such.

The separate database that is encrypted with a master key OvaView possesses rather than each user's UID is still secure; we use E2EE to communicate with that research database, ensuring protection from in-transit vulnerabilities. Moreover, the data contained in this database pertains no extra information which means, like the rest, provide no identifiable link to any of the people the information originated from.

## Discussion

## References

[^1]: https://www.grandviewresearch.com/industry-analysis/womens-health-app-market

[^2]: https://www.invisibly.com/learn-blog/how-much-is-data-worth/

[^3]: https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/Requirements.md#sample-systems

[^4]: https://foundation.mozilla.org/en/privacynotincluded/clue-period-cycle-tracker/

[^5]: https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/Requirements.md#privacy-requirements

[^6]: https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/Requirements.md#functional-requirements
