<a name="readme-top"></a>

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9">
    <img src="https://i.imgur.com/uh1pZQC.png" alt="Logo" width="80" height="80">
  </a>

<h3 align="center">OvaView</h3>
</div>


<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
     <li>
      <a href="#documentation">Documentation</a>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->
## About The Project

<div align="center">
  <a href="https://cs.mcgill.ca/~apopia/comp555/">
    <img src="https://i.imgur.com/wIZXnS1.png" alt="Logo" width="800" height="400">
  </a>
</div>

OvaView aims to simplify the monitoring and organizing of menstrual cycles for users. The period tracker provides a platform to eloquently track, organize, and predict your menstrual health all while keeping your privacy safe and secure. Our system aims to provide a stress-free and elegant way to stay on top of your body's health while ensuring no one else but you gets to track this intimate data.

Our app, in essence, is a simple calendar-style tracker. We offer a mutable calendar UI to each user that can be filled day by day with notes and symptoms related to their menstrual health. There exists one additional feature that users are given opportunities to opt-in to, where the personalized notes they submit are anonymously processed by our proprietary prediction algorithm to receive forecast of future menstrual activity.

### Built With

* SQLite
* Bootstrap
* CSS
* PHP


## Documentation

* [Requirements Document](https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/Requirements.md)
* [Achitectural Description](https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/Architecture.md)
* [Report](https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/Report.md)
* [Contributions](https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/tree/main/contributions)

## Getting Started

This website is currently hosted on the Mcgill CS mimi server (link [here](https://www.cs.mcgill.ca/~bduval2/WebApp/frontEnd/index.php)). However, it is not ready for distribution. For increased privacy and security you are encouraged to host the project locally by following the steps below. 

### Prerequisites

* php = 8.0.28 or 8.1.2 (not tested for other versions)
* SQLite = 3.37.2 or 3.37.3 (not tested for other versions)

### Installation

To host the project locally:

1. Clone the repo:

 ```sh
   git clone https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9.
```

2. Generate a private key and index key by running [WebApp/backEnd/generate_key.php](https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/WebApp/backEnd/generate_key.php). Add these keys where indicated in [WebApp/backEnd/master_logs.php](https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/WebApp/backEnd/master_logs.php).

3. Run [WebApp/frontEnd/index.php](https://gitlab.cs.mcgill.ca/bduval2/comp555-project-group-9/-/blob/main/WebApp/frontEnd/index.php) on your local host. 



