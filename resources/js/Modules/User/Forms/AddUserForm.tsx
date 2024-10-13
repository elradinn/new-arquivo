import React from "react";
import { Button, Flex, Modal, Stack, Text, TextInput } from "@mantine/core";
import { useAddUser } from "../Hooks/use-add-user";

interface IProps {
    isOpened: boolean;
    close: () => void;
}

const AddUserForm: React.FC<IProps> = ({ isOpened, close }) => {
    const { data, setData, submit, processing, errors } = useAddUser();

    const handleClose = () => {
        close();
        // Optionally reset form here if not handled in the hook
    };

    return (
        <Modal opened={isOpened} onClose={handleClose} title={<Text size="lg">Add User</Text>} size={550}>
            <form onSubmit={submit}>
                <Stack gap={16}>
                    <TextInput
                        id="name"
                        type="text"
                        name="name"
                        value={data.name}
                        label="Name"
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                        required
                    />

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        label="Email"
                        onChange={(e) => setData("email", e.target.value)}
                        error={errors.email}
                        required
                    />

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        label="Password"
                        onChange={(e) => setData("password", e.target.value)}
                        error={errors.password}
                        required
                    />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        label="Confirm Password"
                        onChange={(e) => setData("password_confirmation", e.target.value)}
                        error={errors.password_confirmation}
                        required
                    />
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={handleClose}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Save
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default AddUserForm;