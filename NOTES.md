# Notes

This will be where I keep some running notes about my project / class ideas before implementation. It will be treated
as a scratch pad, so it will change constantly, stuff will be removed, etc.

## API endpoint classes

- Probably be coded to an interface, but is trait an option?
- I want an ORM-like pattern to interact with the API


    $this->matchDetails()
        ->where('match_id', '12345')
        ->get();

OR

    $this->matchDetails()
        ->where(['match_id' => '12345'])
        ->get();