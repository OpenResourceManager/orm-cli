# Update

## Installation

Download the latest orm binary from the [releases](https://github.com/OpenResourceManager/orm-cli/releases/) page.

### Step 1 (Unix like system macOS/Linux):

Make the binary executable:

```bash
chmod +x orm;
```

Move the downloaded binary to somewhere in your system path:

```bash
mv orm /usr/local/bin/orm;
```

### Step 1 (Windows): 

Copy the downloaded binary to `C:\Program Files\ORM\bin\`.

### Step 2 (All OS's):

Next you'll need to migrate the database tables.

The command to do this is:

```bash
orm migrate --force
```