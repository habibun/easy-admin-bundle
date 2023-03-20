## About The Project
Implements [EasyAdminBundle][easy_admin_github] in [Symfony][symfony_website]

Please check the [projects](#projects) section for more details.

## Overview
| Branch   | EasyAdmin Version | Symfony Version | PHP Version | Node Version |
|----------|-------------------|-----------------|-------------|--------------|
| [v4][v4] | `^4.0`            | `^6.0`          | `^8.1`      | `v16.13`     | 
| [v2][v2] | `^2.3`            | `^4.4`          | `^7.2`      | `~`          |


## Projects
<details><summary>Simple application using EasyAdminBundle v4</summary>  
<p>

<img
src="https://user-images.githubusercontent.com/5810350/226254914-a20cb91d-da7a-4417-81d4-4733b749986c.png"
alt="easy admin bundle v4"
width="50%"
/>

**Code:** https://github.com/habibun/easy-admin-bundle/tree/v4  
**Resources:** ~  

### Prerequisites
- [Symfony CLI][symfony_cli], [PHP][php], [Composer][composer], [Git][git], [MySQL][mysql], [Node.js][node]

### Installation
```bash
git clone git@github.com:habibun/easy-admin-bundle.git
cd easy-admin-bundle
git checkout v4
symfony composer install
yarn install
```

</p>

##
</details>


<details><summary>Simple application using EasyAdminBundle v2</summary>  
<p>  

<img
src="https://user-images.githubusercontent.com/5810350/226255064-bba19bae-ac88-4ea3-a010-97abb549118c.png"
alt="easy admin bundle v2"
width="50%"
/>

**Code:** https://github.com/habibun/easy-admin-bundle/tree/v2  
**Resources:** ~  


### Prerequisites
- [Symfony CLI][symfony_cli], [PHP][php], [Composer][composer], [Git][git], [MySQL][mysql]

### Installation
Clone the repository using the command:
```git clone git@github.com:habibun/easy-admin-bundle.git```

Navigate into the cloned directory:
```cd easy-admin-bundle```

Checkout: 
```git checkout v2```

#### Manual Instruction

Install the required dependencies using Composer:
```symfony composer install```

Create .env.local file:
`	cp -u -p .env .env.local`

Configure the database connection in the .env.local file:
`DATABASE_URL=mysql://db_user:db_password@db_host/db_name`

Create the database schema:
`symfony console doctrine:schema:create`

Migrate db:
`symfony console doctrine:migrations:migrate -n`

Load sample data into the database:
`symfony console doctrine:fixtures:load -n`

Start the local development server:
`symfony server:start `

#### Makefile Instruction
Create .env.local file:
`make init`

Install project:
`make install`

This will run the same commands as the manual installation process described above.  
Once the installation is complete, start the local development server:
`make start`

</p>

##
</details>


## Learn More
- [EasyAdmin Docs][easy_admin_docs]


## Related
- [Symfony](https://github.com/habibun/symfony)


## License
Distributed under the MIT License. See **[LICENSE][license]** for more information.


[//]: # (Links)
[license]: https://github.com/habibun/easy-admin-bundle/blob/main/LICENSE
[symfony_website]: https://symfony.com/

[easy_admin_github]: https://github.com/EasyCorp/EasyAdminBundle
[easy_admin_docs]: https://symfony.com/bundles/EasyAdminBundle/current/index.html

[v4]: https://github.com/habibun/easy-admin-bundle/tree/v4
[v4_tt]: https://github.com/habibun/easy-admin-bundle/tree/v4 "Simple application using EasyAdminBundle v4"

[v2]: https://github.com/habibun/easy-admin-bundle/tree/v2
[v2_tt]: https://github.com/habibun/easy-admin-bundle/tree/v2 "Simple application using EasyAdminBundle v2"

[symfony_cli]: https://symfony.com/download
[php]: https://www.php.net/
[composer]: https://getcomposer.org/
[git]: https://git-scm.com/
[mysql]: https://www.mysql.com/
[node]: https://nodejs.org/
