# **Report Document**

## Overview of the System

OvaView aims to simplify the monitoring and organizing of menstrual cycles for users. The period tracker provides a platform to eloquently track, organize, and predict your menstrual health all while keeping your privacy safe and secure. Our system aims to provide a stress-free and elegant way to stay on top of your body's health while ensuring no one else but you gets to track this intimate data.

Our app, in essence, is a simple calendar-style tracker. We offer a mutable calendar UI to each user that can be filled day by day with notes and symptoms related to their menstrual health. There exists one additional feature that users are given opportunities to opt-in to, where the personalized notes they submit are processed by our proprietary prediction algorithm to receive forecast of future menstrual activity.

Due to the app's simplistic nature, small development team, and primary goal to maximize user privacy, the stakeholders in our system are few in number. The first would be the _user_, who interacts with our front-end to make use of our service and manipulate their corresponding data in our servers. The next would would be the _front-end_ and _back-end engineers_ who respectively maintain and develop the product users interact with and the architecture handling data flow. The last stakeholder in our system would be the _privacy director_, who plays the role of ensuring and maintaining proper privacy practice in the implementation and development of our product, as well as supervising the training of all employees in our company of the importance of company information security to ensure both the artificial and human vulnerabilities of our system are covered.

The period tracking ecosphere is an almost $4 billion market, yet a fully privacy-minded option is yet to exist [^1]. Women experiencing difficulty managing their menstrual health deserve free access to the resources and aid they need, all the while finding solace in the fact that their intimate details will be kept secret to only themselves. Unfortunately, every app and service existing on the market follow a profit oriented design policy; the truth of the matter is that in our digital world today, you and your data are the product [^2].

To illustrate the harsh reality for period trackers, the two of the largest (by active user count) period tracking apps on both Google and iOS have many vulnerabilities threatening the integrity of user privacy of their systems. _Flo_, the most popular period tracking app, has been egregious enough in their questionable data policies that multiple class action lawsuits have been filed against them for selling named and identified data to major media and advertising companies [^3]. _Clue_, which has been widely regarded as the most privacy-safe options women have on the market, remains to exercise dubious policies and practices. _Clue_, like every other period tracker, requires users to submit their identity to access their service: name, date of birth, city, email, phone number, and more are required fields to submit to create an account. Moreover, instead of letting users choose how to use their product, _Clue_ locks their product behind intimate questions users must answer to proceed onto the main functionalities of the app; inquiries such as sexual activity, sexual habits and symptoms, descriptive details about menstrual activity, and many more. Damning of all, _Clue_ sends their data off to researchers, with the promise that all the data is anonymized; except said data do not censor location of users, making the data easily identifiable and poorly anonymized by concept [^4].

The current landscape of period trackers is not an anomaly; the trend of every service, regardless of whether or not its function requires identified data to perform its job, requiring consumers to submit an abundance of personal information has been around for the past decade and further. Be it calculator or grocery list app, every company is taking advantage of our population becoming more and more normalized to submitting our names and details to receive any online product. This trend is what OvaView sets to confront; our company policies and principles are deliberate, with the goal of differentiating ourselves from the rest of our competition. To provide a service that users can be confident that their data and privacy is safe and in their control, while receiving the quality resources to take care of their health they deserve [^5] [^6].

## Design and Implementation

OvaView has precise, unique design decisions that are worth highlighting and describing. **(go on to describe: no cookies entirely, unique id accounts, employee training, encryption via unique id)**

Our company achieves its goal of protecting our users' privacy by ensuring our system possesses these aspects **(link to req doc)**:

1. Transparent and fair data collection and processing:
2. Responsible data retention
3. Responsible data storage
   * Utilize E2EE to ensure full protection of data in and en-route to our servers
   * Train workers handling architecture and/or data in security safety protocols and practice

We want users to see the entire lifetime of their information in full detail; it is imperative to keep no secrets to achieve mutual respect between the user and service, which is why we take full responsibility in ensuring the user are fully aware of _what_ we require from the users, _how long_ we keep the data we collect, and _inform_ users that they are in full control over their data at all steps of our product process. Furthermore, we felt found it crucial to default users to the minimum data collection to run our service. We wanted to provide accurate menstrual cycle prediction to users, but realized this would require more data processing. We want users to have this option, but have full awareness of what this is all about before opting in.

Data retention can be scary for users: the modern-day fear being that anything posted online is etched into history forever. To combat this, we make sure to ensure users that they are in control of their data, that at any time they can request the viewing, rectification, and deletion of all data linked to their account, with no fickle statements from us trying to dissuade users. Our company chooses to maintain data until the user sees otherwise; because our account system requires no identifiable information whatsoever, none of the data in our servers are actually linked to the user in real life. Due to this, aggregation of data in our servers to identify our users is impossible, meaning the data users forget about and leave in our data to hibernate will never be a risk to their privacy; moreover, this means that users can always come back to our service after a break.

Consumers also want to make sure that any data they do submit is not going to be easily accessed by malicious actors or randomly spilled by the data handler out in public. Our architecture uses

## Discussion

## References

[^1]: https://www.grandviewresearch.com/industry-analysis/womens-health-app-market

[^2]: https://www.invisibly.com/learn-blog/how-much-is-data-worth/

[^3]: https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/Requirements.md#sample-systems

[^4]: https://foundation.mozilla.org/en/privacynotincluded/clue-period-cycle-tracker/

[^5]: https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/Requirements.md#privacy-requirements

[^6]: https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/Requirements.md#functional-requirements
