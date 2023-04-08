# **Requirements Document**

## System Purpose and Scope

Our app is a period tracker with the objective of facilitating the observation and analysis of users' menstrual cycles and related factors, as well as offer a standardized prediction of future menstrual cycles based off input data. Our system intends to allow users to enter their daily menstrual activity on a calendar template, along with optional related factors such as indicators of mood, symptoms, and thoughts.

The main privacy requirements for this system would entail:

1. Transparent and fair data collection and processing
   * Clear consent and opt-out options after consent
   * Clear purposes of data processing outlined to users
   * Default to minimum subjection to data traffic with opt-in options
2. Responsible data retention
   * Retention of data only until needed for intended purposes
   * Compliance to requests of erasure
3. Information encryption in storage
   * Encrypted communications between user interface and database
   * Encrypted storage of data to minimize vulnerabilities from attacks on database

## Sample Systems

In the golden age of information, the most common shady practice by established companies on the market is information disclosure. Most of the time being uninformed disclosure, which turns into an illegal activity, companies who process lots of user data realize the value of these assets to other capitalist entities out there. Targeted advertising has become a plague in the current century, causing an astronomical demand in preference data attached to an identity.

The top fertility app on the Western market, _Flo_, is no stranger to selling un-anonymized user data to various technological titans without user notice [^1] [^2]. In fact, Flo has been prosecuted with numerous lawsuits, leading to a consolidated class action complaint about their consistent mishandling of user data [^3].

Our system intends to handle sensitive information of our userbase with responsibility, transparency, and fairness in mind. Our app strives to let users know exactly what happens with the information they put into our app, as well as cutting off a major concern of this type of sensitive health data: identification. We aim to allow users to pilot our app completely anonymously, only identified by a login token created on registration, without any required personal information. We intend to fully default all users to anonymized tracking, allowing options to opt-in for more rigorous data processing, collection, and disclosure for the intention of app quality enhancement.

To put it comprehensively, here is a list of questionable actions Flo in particular has been either filed for in lawsuits or publicly criticized for:

* Disclosure of user personal information to third parties with no consent, some including
  * Google
  * Flurry
  * AppsFlyer
  * Facebook
* Necessitating users to hand over intimate information to use the app (such as sexual activity, diseases, etc.)
* Disrespecting users by boldly claiming unfairly disclosing intimate information to various advertising companies for profit is "vital to the user"
* Using app revenue, with many implications of said money coming from selling people's data, to defend against multiple lawsuits and class actions motioned against them in court
* Allowing companies to buy sensitive information from Flo without asking for their purposes for said data

There are other systems that attempt to respect user privacy, most notably Clue period tracking app. Unfortunately, they still adhere to malpractices and mistakes, rearing a rather ugly head [^4]. Some of these issues include:

* "Anonymized data" sent out to researchers for diagnostic features on their app known to be easily traceable back to original data subject.
* Strict requirement of potential users to submit PII and other intimate information to register for an account.
* Statements in official privacy policy stating that American users are vulnerable to data disclosure to governmental requests and other geo-specific instances unique to the United States of America.

While at our company, we aim to do the following:

* Allow users to join our app and use it to its full extent without handing over any personal information
* Leave no opportunity for the collection of identifiable data to minimize potential aggregation and/or identification using our database
* Never disclose any of our collected data to any party other than the original data owner
* Keep active consent from users and keep all our data usage transparent
* Never trick users into consenting without knowledge by avoiding complicated agreements or terms
* Default to the bare minimum data requirements for users so they can have full autonomy over what information they hand over to us

## Functional Requirements

Our system's functional requirements are isolated to the website frontend and can be partitioned into the following fields:

* Customized daily entries that are visually eloquent.
  * Users add notes, symptoms, moods, and more on a calendar GUI and have easy navigation, organization, and customization of each day of the month.
  * Entries are partitioned to days of the month for easy organization.
* Option to receive additional feature of menstrual cycle prediction.
  * Based on user logging on our service, anyone willing to opt in will receive an accurate prediction of their next period using our community driven learning algorithm that uses consented user data to learn to predict menstrual activity and ovulation based on symptoms.
* Comprehensive settings page users can practice full data autonomy on. Full access to:
  * Change opt-in/opt-out status for additional features.
  * Request erasure of all personal data linked user.
  * Request erasure of user account entity and all data tied to account.
* Account registration.
  * No personally identifiable information required to sign up.
  * Option to join additional features not encouraged, but available.
* Login / Logout
  * Login requiring only appointed unique 16-digit user ID.
  * Logout leaving no trace or memory of activity on browser.

## Privacy Requirements

Our system's privacy requirements can be partitioned into various fields:

* Encryption
  * We use **end-to-end encryption technology** to keep all our data safe, secure, and away from unwanted eyes. We pivot away from traditional server-side "in transit" encryption to make sure our data flow is secure from all points of contact; end-to-end ensures that <span dir="">encrypted data is only viewable by those with decryption keys</span>, in other words, it <span dir="">prevents both third parties and unintended app users from reading or modifying data when only the intended readers should have this access and ability, blocking out as many sources of information leakage or breach.</span>
  * Our encryption method revolves around using each user's 16-digit identifier as the key, rather than a centralized master key. This means that one user being compromised does not risk any other accounts in the database. Moreover, this implementation implies that if an attacker breaches our database, there is no existence of a master key to access our userbase's information. Our encryption protocol also ensures that even us, the data holders, are unable to encrypt any of the information; only the users are able to provide a method to read their data.
  * This privacy requirement helps prevent many types of attacks and vulnerabilities
    * Man-in-the-middle attacks are more common from users who often use unsecured connections, which encryption will ensure any malicious party intercepting data between our servers and the user will be useless to them.
    * Database breaches either by social engineering, session extraction attacks, or any new breaching technology developed will be futile as intruders would access fully encrypted datasets without a key.
  * E2EE is used for research data users have consented to giving for period prediction analysis. This means that the server holds the secure encryption master key, rather than the user. Data stored in such ways are isolated from our UID dependent E2EE protocol, so as to ensure opted-out users are not affected. 
* Cookies
  * We strictly exclude cookies, both first and third party cookies.
    * Third party cookies create irreparable distrust in the consumer/producer symbiotic relationship, essentially leaving the door open for the producer to freely share data about the consumer, as well as actively tracking users on the platform
    * First-party cookies are acknowledged to be safer, but our system wishes to be completely devoid of any privacy intrusion. Although all information in first-party cookies would be bound to our domain, we want to ensure and give confidence to our users that absolutely no tracking is done when interacting with our website.
* Employee Internet Privacy Education
  * Many companies with the most bolstered security architecture are done in by breachers by either employees being social engineered or operating company connected devices carelessly and allowing for example, session hijacking attacks. In fact, a study has shown that over 93% of public data breaches reported in the UK between 2011 and 2015 were caused by human error in the companies [^5]. With how good security technology has gotten, our company wants to have every potential vulnerability taken care of, down to the human aspect of things.
  * Education can consist of basic internet protocols and safety measures, looks into many prolific companies breached by employees carelessly downloading files from emails or exposing too much data on public platforms, and general good practices when they are working on company devices and off company devices.

## Privacy by Design

Following the 7 Foundational Principles published by privacybydesign [^6].

1. **Proactive** not Reactive; **Preventative** not Remedial
   * Our system's privacy requirements reinforce the idea of preventative features over remedial features. We make sure our data flow is fully encrypted at all sources, endpoints, and everything in between. We also take initiative in requiring employees to become educated in privacy and security, making sure we prevent any creative attacks on us, such as social engineering or session hijacking attacks. Our anonymous account system allows all our collected data to have no possible trail or link back to any personal information on our users; all because we never store any personally identifiable information.
2. Privacy as the **Default** Setting
   * Upon registration, we want users to be fully aware they are defaulted out of any and all data collection, processing, and disclosure deemed additional to the major functions of our app. We would offer opportunities to opt-in to our additional feature of period prediction, but never encourage or persuade users against their will. We intend for users to be able to fully comprehend what we are offering, the consequences it has on their data, and if they are comfortable with said consequences. We feel this is imperative in gaining user trust and respect, while making sure we do the same for them.
3. Privacy **Embedded** into Design
   * Our architecture uses end-to-end encryption for the very specific reason of covering all bases. We recognize the traditional method of server-side encryption has certain vulnerabilities, such as unintended users being able to access supposedly secure data.
4. Full Functionality — **Positive-Sum**, not Zero-Sum
   * All of our practices aim to never take away from the base user experience nor the baseline quality of our app when allowing users to keep their privacy secure. We offer more bells and whistles to users who consent to give up bits of their privacy, but the intended purpose of our app and the target security of our system will be met with no trade-off of user privacy.
5. End-to-End Security — **Full Lifecycle Protection**
   * We ensure that the communication and storage of any data we obtain from users will follow protocols with security and privacy as the highest priority to give consumers peace of mind that their sensitive information do not end up floating in public domains. Moreover, we follow strict principles of the _retention_ of our data; this means that the lifecycle of any information given to us by the user will span the duration of its usage for our outlined purposes and not any longer. We also give our users the guarantee of complete erasure of their data. Although GDPR mandates that companies are within their rights to retain critical information for governmental purposes, we choose to not exercise that right and give consumers full autonomy of their information's lifespan.
6. **Visibility** and **Transparency** — Keep it **Open**
   * Every step before and during a user's commitment to our product will be clear on what exactly our system intends to do with user data, how exactly we obtain said data, the details of how we process, and most importantly, what the user rights are and what users are consenting to with each request for permission. We aim to make every statement from us clear, concise, and unambiguous to show users everything that goes on behind the scenes in the user's data flow in and out of our system.
7. **Respect** for User Privacy — Keep it **User-Centric**
   * A different approach from our competitors is our doctrine regarding user autonomy. We want our users to feel in control of what the app sees and does with the information they present to our product. We want them to pick and choose what kinds of data they value to keep secret, how much they want secret, and who the players are when dealing with their data. We understand it can get overwhelming to configure a balance between extra features and privacy, so we plan to default users to the bare minimum data exposure while maintaining a standard of app functionality we can be proud of, so timid users will not miss out on the key aspects of our product while the privacy-minded can have full autonomy while using our app.

## Links

[^1]: https://www.ftc.gov/news-events/news/press-releases/2021/06/ftc-finalizes-order-flo-health-fertility-tracking-app-shared-sensitive-health-data-facebook-google

[^2]: https://techcrunch.com/2021/01/13/flo-gets-ftc-slap-for-sharing-user-data-when-it-promised-privacy

[^3]: https://www.reuters.com/legal/litigation/fertility-app-maker-flo-health-faces-consolidated-privacy-lawsuit-2021-09-03/

[^4]: https://foundation.mozilla.org/en/privacynotincluded/clue-period-cycle-tracker/

[^5]: Evans, M., Maglaras, L. A., He, Y., and Janicke, H. (2016) Human behaviour as an aspect of cybersecurity assurance. Security Comm. Networks, 9: 4667– 4679. doi: 10.1002/sec.1657.

[^6]: https://www.ipc.on.ca/wp-content/uploads/Resources/7foundationalprinciples.pdf
