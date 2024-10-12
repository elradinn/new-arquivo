import { Button, Flex, Modal, Stack, Text, TextInput } from "@mantine/core";
import React, { FormEventHandler } from "react";
import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";

interface IProps {
    isOpened: boolean;
    close: () => void;
}

const AddUserForm: React.FC<IProps> = ({ isOpened, close }) => {
    const { data, setData, post, processing, errors, reset, clearErrors } = useForm({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });

    const handleClose = () => {
        close();
        reset();
        clearErrors();
    };

    const addMetadataSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route("user.store"), {
            onSuccess: () => {
                handleClose();
                notifications.show({
                    message: "New user added successfully",
                    color: "green",
                });
            },

            onFinish: () => reset(),
        });
    };

    return (
        <Modal opened={isOpened} onClose={close} title={<Text size="lg">Add User</Text>} size={550}>
            <form onSubmit={addMetadataSubmit}>
                <Stack gap={16}>
                    <TextInput
                        id="name"
                        type="name"
                        name="name"
                        value={data.name}
                        autoComplete="name"
                        leftSectionPointerEvents="none"
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
                        mt={4}
                        autoComplete="username"
                        leftSectionPointerEvents="none"
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
                        autoComplete="new-password"
                        leftSectionPointerEvents="none"
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
                        autoComplete="new-password"
                        leftSectionPointerEvents="none"
                        label="Confirm Password"
                        onChange={(e) => setData("password_confirmation", e.target.value)}
                        error={errors.password}
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
