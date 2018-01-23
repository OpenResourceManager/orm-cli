# Command Examples

To see all of the commands run `orm` without any arguments or check the [Command Reference](commands.md).

---

## Rename a user

In this example I'm renaming Anakin Skywalker to Darth Vader. The user's `identifier` attribute is required as an argument when using the patch method. This because usernames are subject to change while identifiers are static.

```bash
orm account:patch 0909090 --name-first Darth --name-last Vader --username vaderd
```

## Change a user's duty

Here I am changing Darth Vader's primary duty from Jedi to Sith, using the duty code.

```bash
orm account:patch 0909090 --primary-duty-code SITH
```

Here I am adding Vader to a secondary duty.

```bash
orm account:attach --identifiier 0909090 --duty-code TRADER
```

Here I am removing Vader from a secondary duty.

```bash
orm account:detach --identifiier 0909090 --duty-code JEDI
```

## Delete a user

Here I am deleting Darth Vader's account using his identifier.

```bash
orm account:delete -i 0909090
```

Here I am deleting Darth Vader's account using his username.

```bash
orm account:delete -u vaderd
```

Here I am performing a mass deletion based on a JSON array of identifiers. 

```bash
orm account:delete -j ~/jedi_list.json
```

An example of `jedi_list.json`:

```json
[
  "0909090",
  "0909091",
  "0909092",
  "0909093"
]
```