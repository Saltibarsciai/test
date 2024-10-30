to setup project, you'll need Docker


```
make setup
```

visit http://localhost:8000/api/jobs to see all redis data

lookup specific job example http://localhost:8000/api/jobs/58bb1963-1938-4df4-9290-e5fd8b56625a

to create you'll have to use postman on http://localhost:8000/api/jobs

execute create endpoint with this body, you'll get created job ids

```
{
    "urls": [
        "https://scrapeme.live/",
        "https://scrapeme.live/shop"
    ],
    "selectors": [
        "title"
    ]
}
```
