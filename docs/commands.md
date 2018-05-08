# Command Reference

To see a few examples check out the [Command Examples](examples.md) page.

---

Open Resource Manager CLI v0.2.0

```bash
USAGE: orm <command> [options] [arguments]

  migrate                Run the database migrations
  verify                 Verify an object with a verification token.

  account:attach         Attach an ORM Account by it's id, identifier, or username to a duty, course, school, department, or room by their ID or code.
  account:delete         Delete an ORM Account by it's id, identifier, or username.
  account:detach         Detach an ORM Account by it's id, identifier, or username to a duty, course, school, department, or room by their ID or code.
  account:patch          Update existing account information based in it's identifier.
  account:show           Show an ORM Account by it's ID, identifier, or username. Displays a paginated list when those parameters are omitted, a page parameter is available.
  account:store          Store account information. Creates, updates, restores, an account based on it's current status.

  address:delete         Delete an Address by it's id.
  address:show           Show an Address by it's ID, account ID, identifier, or username. Displays a paginated list when those parameters are omitted, a page parameter is available.
  address:store          Store an address. Creates, updates, restores, an address based on it's current status.

  alias-account:delete   Deletes an Alias Account by it's ID, or username.
  alias-account:show     Show an Alias Account by it's ID, or username. Displays a paginated list when those parameters are omitted, a page parameter is available.
  alias-account:store    Store Alias Account information. Creates, updates, restores, an alias account based on it's current status.

  building:delete        Deletes a Building by it's ID, or code.
  building:show          Show an Building by it's ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.
  building:store         Store Building information. Creates, updates, restores, a building based on it's current status.

  campus:delete          Deletes a Campus by it's ID, or code.
  campus:show            Show a Campus by it's ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.
  campus:store           Store Campus information. Creates, updates, restores, a campus based on it's current status.

  carrier:delete         Deletes a Mobile Carrier by it's ID, or code.
  carrier:show           Show a Mobile Carrier by it's ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.
  carrier:store          Store Mobile Carrier information. Creates, updates, restores, a mobile carrier based on it's current status.

  country:delete         Deletes a Country by it's ID, or code.
  country:show           Show a Country by it's ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.
  country:store          Store Country information. Creates, updates, restores, a country based on it's current status.

  course:delete          Deletes a Room by it's ID, or code.
  course:show            Show a Course by it's ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.
  course:store           Store Course information. Creates, updates, restores, a course based on it's current status.

  department:delete      Deletes a Department by it's ID, or code.
  department:show        Show a Department by it's ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.
  department:store       Store Department information. Creates, updates, restores, a department based on it's current status.

  duty:delete            Deletes a Duty by it's ID, or code.
  duty:show              Show a Duty by it's ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.
  duty:store             Store Duty information. Creates, updates, restores, a duty based on it's current status.

  email:delete           Deletes an Email by it's ID, or address.
  email:show             Show an Email by it's ID, or address. Displays a paginated list when those parameters are omitted, a page parameter is available.
  email:store            Store Email information. Creates, updates, restores, an email address based on it's current status.
  email:verify           Verify an email address with a verification token.

  load-status:delete     Deletes a Load Status by it's ID, or code.
  load-status:show       Show a Load Status by it's ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.
  load-status:store      Store Load Status information. Creates, updates, restores, a load status based on it's current status.

  mobile:delete          Deletes a Mobile Phone by it's ID.
  mobile:show            Show a Mobile Phone by it's ID. Displays a paginated list when those parameters are omitted, a page parameter is available.
  mobile:store           Store Mobile Phone information. Creates, updates, restores, a mobile phone based on it's current status.
  mobile:verify          Verify a mobile phone with a verification token.

  profile:delete         Delete a stored ORM profile
  profile:show           Displays stored profiles
  profile:store          Stores ORM API credentials and server information
  profile:switch         Switch the currently active ORM profile

  room:show              Show a Room by it's ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.
  room:store             Store Room information. Creates, updates, restores, a room based on it's current status.

  school:delete          Deletes a School by it's ID, or code.
  school:show            Show a School by it's ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.
  school:store           Store Room information. Creates, updates, restores, a room based on it's current status.

  service-account:delete Deletes an Alias Account by it's ID, or username.
  service-account:show   Show a Service Account by it's ID, or username. Displays a paginated list when those parameters are omitted, a page parameter is available.
  service-account:store  Store Service Account information. Creates, updates, restores, a service account based on it's current status.

  state:delete           Deletes a State by it's ID, or code.
  state:show             Show a State by it's ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.
  state:store            Store State information. Creates, updates, restores, a state based on it's current status.
```