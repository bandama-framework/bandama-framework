CREATE TABLE sessions(
     session_id VARCHAR(255) NOT NULL, -- This is the identity of the session, so it must be the primary key
     session_data MEDIUMTEXT NOT NULL, -- This must be big enough to hold the largest $_SESSION array that your application is liable to produce.
     session_lifetime MEDIUMINT NOT NULL, -- It specify the lifetime of session
     user_id VARCHAR(50) NULL, -- This is used to identify the person to whom this session belongs. The value is provided by the application logon screen.
     created_at BIGINT NOT NULL, -- This is used to identify when the session was started.
     updated_at BIGINT NOT NULL, -- This is used to identify when the last request was processed for the session. This is also used in garbage collection to remove those sessions which have been inactive for a period of time.
     PRIMARY KEY(session_id)
 ) COLLATE utf8_bin, ENGINE = InnoDB;
