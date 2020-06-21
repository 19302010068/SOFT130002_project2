data.search =
    {
        callbacks: [],
        init(self)
        {
            for (const callback of this.callbacks)
                callback(self);
        },
    };